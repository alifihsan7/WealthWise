<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FinancialGoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FinancialGoalController extends Controller
{
    /**
     * 1. Mengambil semua goals milik user yang sedang login
     */
    public function index()
    {
        $userId = Auth::id();
        $goals = FinancialGoal::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $goals
        ], 200);
    }

    /**
     * 2. Menyimpan goal baru (Smart Planning)
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'goal_name'         => 'required|string|max:255',
            'target_amount'     => 'required|numeric|min:1',
            'filling_plan'      => 'required|in:DAILY,WEEKLY,MONTHLY,YEARLY',
            'amount_per_period' => 'required|numeric|min:1',
            'start_date'        => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $goal = FinancialGoal::create([
            'user_id'           => Auth::id(),
            'goal_name'         => $request->goal_name,
            'target_amount'     => $request->target_amount,
            'current_amount'    => $request->current_amount ?? 0,
            'filling_plan'      => $request->filling_plan,
            'amount_per_period' => $request->amount_per_period,
            'start_date'        => $request->start_date,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Goal berhasil dibuat!',
            'data' => $goal
        ], 210);
    }

    /**
     * 3. Menampilkan detail satu goal
     */
    public function show($id)
    {
        $goal = FinancialGoal::where('user_id', Auth::id())->find($id);

        if (!$goal) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $goal
        ]);
    }

    /**
     * 4. Memperbarui data goal (Edit atau Tambah Saldo Tabungan)
     */
    public function update(Request $request, $id)
    {
        $goal = FinancialGoal::where('user_id', Auth::id())->find($id);

        if (!$goal) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Validasi opsional (sometimes) agar tidak semua field wajib dikirim saat update
        $validator = Validator::make($request->all(), [
            'goal_name'         => 'sometimes|string',
            'current_amount'    => 'sometimes|numeric',
            'target_amount'     => 'sometimes|numeric',
            'amount_per_period' => 'sometimes|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $goal->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Goal berhasil diperbarui',
            'data' => $goal
        ]);
    }

    /**
     * 5. Menghapus goal
     */
    public function destroy($id)
    {
        $goal = FinancialGoal::where('user_id', Auth::id())->find($id);

        if (!$goal) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $goal->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Goal berhasil dihapus'
        ]);
    }
}