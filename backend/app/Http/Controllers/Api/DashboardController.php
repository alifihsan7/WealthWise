<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FinancialStatsService;
use App\Services\TransactionService; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $statsService;
    protected $transactionService;

    public function __construct(FinancialStatsService $statsService, TransactionService $transactionService)
    {
        $this->statsService = $statsService;
        $this->transactionService = $transactionService;
    }

    public function index()
    {
        $userId = Auth::id();

        $stats = $this->statsService->getDashboardSummary($userId);
        $recentTransactions = $this->transactionService->getRecent($userId, 5);

        return response()->json([
            'summary' => $stats,
            'recent_transactions' => $recentTransactions
        ]);
    }
}