<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller; 
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['category', 'account'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($trx) {
                return [
                    'id'                 => $trx->id,
                    'transaction_amount' => $trx->transaction_amount,
                    'transaction_type'   => $trx->transaction_type,
                    'transaction_date'   => $trx->transaction_date,
                    'description'        => $trx->description,
                    'category'           => [
                        'id'   => $trx->category->id,
                        'name' => $trx->category->category_name,
                    ],
                    'account'            => [
                        'id'   => $trx->account->id,
                        'name' => $trx->account->account_name,
                    ],
                ];
            });
            
        return response()->json([
            'status' => 'success',
            'data' => $transactions
        ], 200);
    }
    

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account_id'       => 'required|exists:accounts,id',
            'type'             => 'required|in:INCOME,EXPENSE,TRANSFER',
            'amount'           => 'required|numeric|min:1',
            'transaction_date' => 'required|date',
            'category_id'      => 'nullable|exists:categories,id',
            'description'      => 'nullable|string',
            'to_account_id'    => 'nullable|required_if:type,TRANSFER|exists:accounts,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        if ($request->type === 'TRANSFER' && $request->account_id == $request->to_account_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Akun sumber dan tujuan tidak boleh sama.'
            ], 422);
        }

        $transaction = Transaction::create([
            'user_id'            => Auth::id(),
            'account_id'         => $request->account_id,
            'category_id'        => $request->category_id,
            'to_account_id'      => $request->to_account_id,
            'transaction_type'   => $request->type,   
            'transaction_amount' => $request->amount,
            'transaction_date'   => $request->transaction_date,
            'description'        => $request->description,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Transaksi berhasil dicatat.',
            'data' => $transaction
        ], 201);
    }

    public function show($id)
    {
        $transaction = Transaction::where('user_id', Auth::id())->find($id);

        if (!$transaction) {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaksi tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $transaction
        ], 200);
    }
    
    public function update(Request $request, $id)
    {
        $transaction = Transaction::where('user_id', Auth::id())->find($id);

        if (!$transaction) {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaksi tidak ditemukan.'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'account_id' => 'required|exists:accounts,id',
            'type' => 'required|in:INCOME,EXPENSE,TRANSFER',
            'amount' => 'required|numeric|min:1',
            'transaction_date' => 'required|date',
            'category_id' => 'nullable|exists:categories,id',
            'to_account_id' => 'nullable|required_if:type,TRANSFER|exists:accounts,id',
            'description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $transaction->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Transaksi berhasil diperbarui.',
            'data' => $transaction
        ], 200);
    }

    /**
     * Menghapus transaksi (Soft Delete).
     */
    public function destroy($id)
    {
        $transaction = Transaction::where('user_id', Auth::id())->find($id);

        if (!$transaction) {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaksi tidak ditemukan.'
            ], 404);
        }

        $transaction->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Transaksi berhasil dihapus.'
        ], 200);
    }
}