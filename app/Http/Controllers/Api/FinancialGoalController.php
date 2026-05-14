<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FinancialGoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class FinancialGoalController extends Controller
{
    // ─── GET /api/goals ───────────────────────────────────────────
    public function index()
    {
        $goals = FinancialGoal::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $goals,
        ]);
    }

    // ─── POST /api/goals ──────────────────────────────────────────
    public function store(Request $request)
    {
        $validated = $request->validate([
            'goal_name'    => 'required|string|max:255',
            'target_amount'=> 'required|numeric|min:1000',
            'start_date'   => 'required|date',
            'target_date'  => 'required|date|after:start_date',
            'filling_plan' => 'required|string|in:DAILY,WEEKLY,MONTHLY',
            'icon'         => 'nullable|string|max:10',
            'color_theme'  => 'nullable|string|max:20',
        ]);

        // Validasi: plan tersedia untuk durasi ini?
        $validated['filling_plan'] = strtoupper($validated['filling_plan']);
        $availablePlans = FinancialGoal::calculateAvailablePlans(
            $validated['target_amount'],
            $validated['start_date'],
            $validated['target_date']
        );
        $availablePlanNames = array_column($availablePlans, 'plan');

        if (!in_array($validated['filling_plan'], $availablePlanNames)) {
            return response()->json([
                'success' => false,
                'message' => "Plan '{$validated['filling_plan']}' is not available for this duration.",
                'available_plans' => $availablePlans,
            ], 422);
        }

        // Hitung otomatis — frontend TIDAK perlu kirim amount_per_period
        $amountPerPeriod = FinancialGoal::calculateAmountPerPeriod(
            $validated['target_amount'],
            $validated['filling_plan'],
            $validated['start_date'],
            $validated['target_date']
        );

        $goal = FinancialGoal::create([
            'user_id'          => Auth::id(),
            'goal_name'        => $validated['goal_name'],
            'target_amount'    => $validated['target_amount'],
            'current_amount'   => 0,
            'filling_plan'     => $validated['filling_plan'],
            'amount_per_period'=> $amountPerPeriod,
            'start_date'       => $validated['start_date'],
            'target_date'      => $validated['target_date'],
            'icon'             => $validated['icon'] ?? '🎯',
            'color_theme'      => $validated['color_theme'] ?? '#6366f1',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Goal created successfully.',
            'data'    => $goal,
        ], 201);
    }

    // ─── GET /api/goals/{id} ──────────────────────────────────────
    public function show($id)
    {
        $goal = FinancialGoal::where('user_id', Auth::id())->findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => $goal,
        ]);
    }

    // ─── PUT /api/goals/{id} ──────────────────────────────────────
    public function update(Request $request, $id)
    {
        $goal = FinancialGoal::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'goal_name'     => 'sometimes|string|max:255',
            'target_amount' => 'sometimes|numeric|min:1000',
            'start_date'    => 'sometimes|date',
            'target_date'   => 'sometimes|date|after:start_date',
            'filling_plan'  => 'sometimes|string|in:DAILY,WEEKLY,MONTHLY',
            'current_amount'=> 'sometimes|numeric|min:0',
            'icon'          => 'nullable|string|max:10',
            'color_theme'   => 'nullable|string|max:20',
        ]);

        // Merge dengan data existing agar kalkulasi tetap akurat
        $targetAmount = $validated['target_amount'] ?? $goal->target_amount;
        $startDate    = $validated['start_date']    ?? $goal->start_date;
        $targetDate   = $validated['target_date']   ?? $goal->target_date;
        $fillingPlan  = $validated['filling_plan']  ?? $goal->filling_plan;

        // Recalculate jika ada perubahan finansial
        $shouldRecalc = isset($validated['target_amount'])
            || isset($validated['start_date'])
            || isset($validated['target_date'])
            || isset($validated['filling_plan']);

        if ($shouldRecalc) {
            $availablePlans     = FinancialGoal::calculateAvailablePlans($targetAmount, $startDate, $targetDate);
            $availablePlanNames = array_column($availablePlans, 'plan');

            if (!in_array($fillingPlan, $availablePlanNames)) {
                return response()->json([
                    'success'         => false,
                    'message'         => "Plan '{$fillingPlan}' is not available for this duration.",
                    'available_plans' => $availablePlans,
                ], 422);
            }

            $validated['amount_per_period'] = FinancialGoal::calculateAmountPerPeriod(
                $targetAmount, $fillingPlan, $startDate, $targetDate
            );
        }

        $goal->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Goal updated successfully.',
            'data'    => $goal->fresh(),
        ]);

        if (isset($validated['filling_plan'])) {
            $validated['filling_plan'] = strtoupper($validated['filling_plan']);
        }
    }


    public function updateFunds(Request $request, $id)
    {
        $goal = FinancialGoal::where(
            'user_id',
            Auth::id()
        )->find($id);

        if (!$goal) {
            return response()->json([
                'message' => 'Goal tidak ditemukan'
            ], 404);
        }

        $validated = Validator::make(
            $request->all(),
            [
                'type' => 'required|in:increase,decrease',
                'amount' => 'required|numeric|min:1',
            ]
        );

        if ($validated->fails()) {

            return response()->json([
                'status' => 'error',
                'errors' => $validated->errors()
            ], 422);

        }

        $amount = $request->amount;

        if ($request->type === 'increase') {

            $goal->current_amount += $amount;

        } else {

            $goal->current_amount -= $amount;

            if ($goal->current_amount < 0) {
                $goal->current_amount = 0;
            }
        }

        $goal->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Funds berhasil diperbarui',
            'data' => $goal->fresh(),
        ]);
    }

    // ─── DELETE /api/goals/{id} ───────────────────────────────────
    public function destroy($id)
    {
        $goal = FinancialGoal::where('user_id', Auth::id())->findOrFail($id);
        $goal->delete();

        return response()->json([
            'success' => true,
            'message' => 'Goal deleted successfully.',
        ]);
    }

    // ─── POST /api/goals/{id}/add-funds ───────────────────────────
    // (Optional endpoint untuk Add Funds modal)
    public function addFunds(Request $request, $id)
    {
        $goal = FinancialGoal::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'amount'    => 'required|numeric|min:1',
            'operation' => 'required|in:add,subtract',
        ]);

        if ($validated['operation'] === 'add') {
            $goal->current_amount = min(
                $goal->target_amount,
                $goal->current_amount + $validated['amount']
            );
        } else {
            $goal->current_amount = max(0, $goal->current_amount - $validated['amount']);
        }

        $goal->save();

        return response()->json([
            'success' => true,
            'message' => 'Funds updated successfully.',
            'data'    => $goal->fresh(),
        ]);
    }
}