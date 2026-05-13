<?php

namespace App\Http\Controllers\Api; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account; 

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
        $accounts = Account::where('user_id', auth()->id())->get();
        return response()->json($accounts);
    }

    public function totalBalance()
    {
        $total = Account::where('user_id', auth()->id())->sum('balance');

        return response()->json([
            'total' => $total
        ]);
    }
}