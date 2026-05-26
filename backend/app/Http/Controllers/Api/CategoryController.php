<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        $period = $request->query('period', 'monthly');
        $year   = (int) $request->query('year',  now()->year);
        $month  = (int) $request->query('month', now()->month);

        $categories = Category::where(function ($query) use ($userId) {
                $query->where('user_id', $userId)
                      ->orWhereNull('user_id');
            })
            ->get()
            ->map(function ($category) use ($userId, $period, $year, $month) {
                $data = $category->toArray();

                if ($category->type === 'EXPENSE') {
                    $txQuery = $category->transactions()
                        ->where('user_id', $userId)
                        ->where('transaction_type', 'EXPENSE')
                        ->whereYear('transaction_date', $year);

                    if ($period === 'monthly') {
                        $txQuery->whereMonth('transaction_date', $month);
                    }

                    $data['spent'] = (float) $txQuery->sum('transaction_amount');
                }

                return $data;
            });

        return response()->json([
            'status' => 'success',
            'data'   => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category_name' => 'required|string|max:255',
            'type'          => 'required|in:INCOME,EXPENSE',
            'budget_limit'  => 'nullable|numeric|min:0',
            'budget_period' => 'nullable|in:WEEKLY,MONTHLY,YEARLY',
        ]);

        $validatedData['user_id'] = Auth::id();

        if ($validatedData['type'] !== 'EXPENSE') {
            $validatedData['budget_limit']  = null;
            $validatedData['budget_period'] = null;
        }

        $category = Category::create($validatedData);

        return response()->json([
            'status'  => 'success',
            'message' => 'Category created successfully',
            'data'    => $category,
        ], 201);
    }

    public function show(string $id)
    {
        $userId = Auth::id();
        $year  = now()->year;
        $month = now()->month;

        $category = Category::where(function ($query) use ($userId) {
                $query->where('user_id', $userId)
                      ->orWhereNull('user_id');
            })
            ->where('id', $id)
            ->first();

        if (!$category) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Category not found',
            ], 404);
        }

        $data = $category->toArray();

        if ($category->type === 'EXPENSE') {
            $data['spent'] = (float) $category->transactions()
                ->where('user_id', $userId)
                ->where('transaction_type', 'EXPENSE')
                ->whereYear('transaction_date', $year)
                ->whereMonth('transaction_date', $month)
                ->sum('transaction_amount');
        }

        return response()->json([
            'status' => 'success',
            'data'   => $data,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $category = Category::where('user_id', Auth::id())->find($id);

        if (!$category) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Category not found or you do not have permission to edit this',
            ], 403);
        }

        $validatedData = $request->validate([
            'category_name' => 'sometimes|required|string|max:255',
            'type'          => 'sometimes|required|in:INCOME,EXPENSE',
            'budget_limit'  => 'nullable|numeric|min:0',
            'budget_period' => 'nullable|in:WEEKLY,MONTHLY,YEARLY',
        ]);

        $type = $validatedData['type'] ?? $category->type;
        if ($type !== 'EXPENSE') {
            $validatedData['budget_limit']  = null;
            $validatedData['budget_period'] = null;
        }

        $category->update($validatedData);

        return response()->json([
            'status'  => 'success',
            'message' => 'Category updated successfully',
            'data'    => $category,
        ]);
    }

    public function destroy(string $id)
    {
        $category = Category::where('user_id', Auth::id())->find($id);

        if (!$category) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Category not found or you do not have permission to delete this',
            ], 403);
        }

        $category->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Category deleted successfully',
        ]);
    }
}
