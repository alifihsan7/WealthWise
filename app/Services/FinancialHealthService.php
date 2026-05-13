<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Account;
use App\Models\Insight;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class FinancialHealthService
{
    public function getSummaryData()
    {
        $userId = Auth::id(); // Asumsi user login

        $transactions = Transaction::where('user_id', $userId)->get();
        $accounts = Account::where('user_id', $userId)->get();

        // --- 1. KALKULASI DASAR ---
        $totalIncome = $transactions->where('transaction_type', 'INCOME')->sum('transaction_amount');
        $totalExpense = $transactions->where('transaction_type', 'EXPENSE')->sum('transaction_amount');
        $netWorth = $accounts->sum('balance');

        $savingRatio = $totalIncome > 0 ? round((($totalIncome - $totalExpense) / $totalIncome) * 100) : 0;
        $expenseRatio = $totalIncome > 0 ? round(($totalExpense / $totalIncome) * 100) : 0;
        
        $avgMonthlyExpense = $totalExpense > 0 ? $totalExpense : 1;
        $emergencyMonths = round($netWorth / $avgMonthlyExpense, 1);
        $dtiRatio = $totalIncome > 0 ? round(($totalExpense / $totalIncome) * 100) : 0;

        $score = 100;
        if ($expenseRatio > 70) $score -= 30; elseif ($expenseRatio > 50) $score -= 15;
        if ($savingRatio < 10) $score -= 20; elseif ($savingRatio < 20) $score -= 10;
        if ($emergencyMonths < 3) $score -= 20; elseif ($emergencyMonths < 6) $score -= 10;
        $score = max(0, min(100, $score));

        // --- 2. LOGIKA AI INSIGHTS ---
        
        // Cek apakah insight hari ini sudah digenerate agar tidak boros API Groq
        $todayInsights = Insight::where('user_id', $userId)
                                ->whereDate('created_at', Carbon::today())
                                ->get();

        // Jika database belum punya insight hari ini, panggil Groq!
        if ($todayInsights->isEmpty() && ($totalIncome > 0 || $totalExpense > 0)) {
            $todayInsights = $this->generateInsightsFromGroq($userId, $savingRatio, $expenseRatio, $emergencyMonths, $score);
        }

        return [
            'summary' => [
                'netWorth' => $netWorth,
                'savingRatio' => $savingRatio,
                'expenseRatio' => $expenseRatio,
                'emergencyMonths' => $emergencyMonths,
                'dtiRatio' => $dtiRatio,
                'score' => $score,
            ],
            // Map data dari database agar formatnya cocok dengan React
            'insights' => $todayInsights->map(function ($insight) {
                return [
                    'emoji' => $insight->emoji,
                    'title' => $insight->title,
                    'desc' => $insight->desc,
                    'actionLabel' => $insight->actionLabel,
                    'urgent' => (bool) $insight->urgent,
                ];
            })
        ];
    }

    // Fungsi khusus menembak Groq dan menyimpan JSON-nya
    private function generateInsightsFromGroq($userId, $savingRatio, $expenseRatio, $emergencyMonths, $score)
    {
        $prompt = "Kamu adalah analis keuangan. Analisis profil pengguna berikut:\n" .
                  "- Saving Ratio: {$savingRatio}%\n" .
                  "- Expense Ratio: {$expenseRatio}%\n" .
                  "- Dana Darurat: {$emergencyMonths} bulan\n" .
                  "- Skor Kesehatan: {$score}/100\n\n" .
                  "Buat 2 insight penting dalam Bahasa Indonesia. " .
                  "WAJIB kembalikan response HANYA dalam format JSON ARRAY murni (tanpa tag markdown ```json). " .
                  "Format persis seperti ini:\n" .
                  '[{"emoji": "🚨", "title": "Judul", "desc": "Penjelasan detail maksimal 2 kalimat", "actionLabel": "Teks Tombol", "urgent": true}]';

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('GROQ_API_KEY'),
                'Content-Type' => 'application/json',
            ])->post('[https://api.groq.com/openai/v1/chat/completions](https://api.groq.com/openai/v1/chat/completions)', [
                'model' => 'llama-3.3-70b-versatile',
                'messages' => [['role' => 'system', 'content' => $prompt]],
                'temperature' => 0.4, // Suhu rendah agar AI fokus pada format JSON
            ]);

            if ($response->successful()) {
                $content = $response->json()['choices'][0]['message']['content'];
                
                // Bersihkan tag markdown jika AI membandel
                $content = str_replace(['
```json', '```'], '', $content);
                $aiInsights = json_decode(trim($content), true);

                if (is_array($aiInsights)) {
                    // Simpan hasil dari Groq ke Database
                    foreach ($aiInsights as $item) {
                        Insight::create([
                            'user_id' => $userId,
                            'emoji' => $item['emoji'] ?? '💡',
                            'title' => $item['title'] ?? 'Insight Keuangan',
                            'desc' => $item['desc'] ?? '-',
                            'actionLabel' => $item['actionLabel'] ?? null,
                            'urgent' => $item['urgent'] ?? false,
                        ]);
                    }
                    // Ambil ulang dari database agar ID terikat
                    return Insight::where('user_id', $userId)->whereDate('created_at', Carbon::today())->get();
                }
            }
        } catch (\Exception $e) {
            // Jika API Groq error/down, kembalikan collection kosong agar aplikasi tidak crash
            return collect([]); 
        }

        return collect([]);
    }
}