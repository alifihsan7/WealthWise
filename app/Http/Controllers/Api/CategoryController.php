<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Menampilkan daftar kategori milik pengguna dan default sistem.
     */
    public function index()
    {
        $categories = Category::where('user_id', Auth::id())
            ->orWhereNull('user_id')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $categories
        ]);
    }

    /**
     * Menyimpan kategori baru (custom) milik pengguna.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category_name' => 'required|string|max:255',
            'type' => 'required|in:INCOME,EXPENSE',
        ]);

        $validatedData['user_id'] = Auth::id();

        $category = Category::create($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'Category created successfully',
            'data' => $category
        ], 201);
    }

    /**
     * Menampilkan detail satu kategori.
     */
    public function show(string $id)
    {
        $category = Category::where(function($query) {
                $query->where('user_id', Auth::id())
                      ->orWhereNull('user_id');
            })
            ->where('id', $id)
            ->first();

        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $category
        ]);
    }

    /**
     * Mengupdate kategori custom milik pengguna.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::where('user_id', Auth::id())->find($id);

        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found or you do not have permission to edit this'
            ], 403);
        }

        $validatedData = $request->validate([
            'category_name' => 'sometimes|required|string|max:255',
            'type' => 'sometimes|required|in:INCOME,EXPENSE',
        ]);

        $category->update($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'Category updated successfully',
            'data' => $category
        ]);
    }

    /**
     * Menghapus kategori custom milik pengguna.
     */
    public function destroy(string $id)
    {
        $category = Category::where('user_id', Auth::id())->find($id);

        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found or you do not have permission to delete this'
            ], 403);
        }

        $category->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Category deleted successfully'
        ]);
    }
}