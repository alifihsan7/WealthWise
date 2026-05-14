<?php

namespace App\Http\Controllers\Api; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account; 
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    // Tampilkan semua akun milik user
    public function index()
    {
        $accounts = Account::where('user_id', Auth::id())->get();
        return response()->json($accounts);
    }

    // Simpan akun baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_name' => 'required|string|max:255',
            'account_type' => 'required|string',
            'balance'      => 'required|numeric',
        ]);

        $account = Account::create([
            'user_id'      => Auth::id(),
            'account_name' => $validated['account_name'],
            'account_type' => $validated['account_type'],
            'balance'      => $validated['balance']
        ]);

        return response()->json($account, 201);
    }

    // --- FUNGSI BARU UNTUK EDIT ---

    /**
     * Ambil SATU data akun untuk EditAccountPage
     */
    public function show($id)
    {
        // Cari akun berdasarkan ID dan pastikan milik user yang sedang login
        $account = Account::where('user_id', Auth::id())->find($id);

        if (!$account) {
            return response()->json(['message' => 'Akun tidak ditemukan'], 404);
        }

        return response()->json($account);
    }

    /**
     * Update data akun dari EditAccountPage
     */
    public function update(Request $request, $id)
    {
        $account = Account::where('user_id', Auth::id())->find($id);

        if (!$account) {
            return response()->json(['message' => 'Akun tidak ditemukan'], 404);
        }

        $validated = $request->validate([
            'account_name' => 'required|string|max:255',
            'account_type' => 'required|string',
            'balance'      => 'required|numeric',
        ]);

        $account->update($validated);

        return response()->json([
            'status' => 'success',
            'data'   => $account
        ]);
    }

    /**
     * Hapus akun
     */
    public function destroy($id)
    {
        $account = Account::where('user_id', Auth::id())->find($id);

        if (!$account) {
            return response()->json(['message' => 'Akun tidak ditemukan'], 404);
        }

        $account->delete();

        return response()->json(['message' => 'Akun berhasil dihapus']);
    }

    // --- FUNGSI TOTAL BALANCE ---

    public function totalBalance()
    {
        $total = Account::where('user_id', Auth::id())->sum('balance');
        return response()->json(['total' => $total]);
    }
}