<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function store(Request $request)
    {
    $account = Account::create([
        'user_id' => auth()->id(),
        'account_name' => $request->account_name,
        'account_type' => $request->account_type,
        'balance' => $request->balance ?? 0
    ]);

    return response()->json($account);
    }

    public function index()
    {
    return Account::where('user_id', auth()->id())->get();
    }

    public function totalBalance()
    {
    $total = Account::where('user_id', auth()->id())->sum('balance');

    return response()->json([
        'total' => $total
    ]);
    }
}
