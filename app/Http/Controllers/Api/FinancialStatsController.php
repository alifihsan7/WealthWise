<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FinancialStatsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinancialStatsController extends Controller
{
    protected $statsService;

    public function __construct(FinancialStatsService $statsService)
    {
        $this->statsService = $statsService;
    }

    /**
     * Endpoint API untuk mengambil statistik
     */
    public function index(Request $request)
    {
        $userId = Auth::id();

        $stats = $this->statsService->getDashboardSummary($userId);

        return response()->json([
            'message' => 'Statistik berhasil dimuat',
            'data'    => $stats
        ], 200);
    }
}