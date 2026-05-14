<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ReceiptScanController extends Controller
{
    public function scan(Request $request)
    {
        $request->validate([
            'receipt' => 'required|file|mimes:jpg,jpeg,png,webp,gif|max:10240',
        ]);

        $file     = $request->file('receipt');
        $base64   = base64_encode(file_get_contents($file->getRealPath()));
        $mimeType = $file->getMimeType();

        $apiKey = config('services.groq.key');

        if (!$apiKey) {
            return response()->json([
                'status'  => 'error',
                'message' => 'API key tidak dikonfigurasi.',
            ], 500);
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type'  => 'application/json',
        ])->timeout(30)->post('https://api.groq.com/openai/v1/chat/completions', [
            'model'      => 'meta-llama/llama-4-scout-17b-16e-instruct',
            'max_tokens' => 512,
            'messages'   => [
                [
                    'role'    => 'user',
                    'content' => [
                        [
                            'type'      => 'image_url',
                            'image_url' => [
                                'url' => "data:{$mimeType};base64,{$base64}",
                            ],
                        ],
                        [
                            'type' => 'text',
                            'text' => <<<PROMPT
Analyze this receipt image and extract the transaction details.
Return ONLY a valid JSON object with exactly these fields:
{
  "description": "merchant name and brief description of purchase",
  "amount": 150000,
  "transaction_date": "2026-05-14",
  "type": "EXPENSE"
}
Rules:
- amount: integer in IDR (Indonesian Rupiah), no decimals
- transaction_date: format YYYY-MM-DD, use today if not visible
- type: always "EXPENSE" for receipts
- description: concise, max 100 chars
Return ONLY the JSON object, no other text.
PROMPT,
                        ],
                    ],
                ],
            ],
        ]);

        if ($response->failed()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menghubungi layanan AI. Coba lagi.',
            ], 502);
        }

        $rawText = $response->json('choices.0.message.content', '');

        // Extract JSON (handle possible markdown code blocks)
        preg_match('/\{[^{}]*\}/s', $rawText, $matches);
        $jsonString = $matches[0] ?? $rawText;

        $data = json_decode($jsonString, true);

        if (!$data || !isset($data['amount'])) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal membaca data dari struk. Pastikan gambar jelas dan terbaca.',
            ], 422);
        }

        $data['amount']           = (int) ($data['amount'] ?? 0);
        $data['description']      = substr($data['description'] ?? '', 0, 100);
        $data['transaction_date'] = $data['transaction_date'] ?? now()->format('Y-m-d');
        $data['type']             = 'EXPENSE';

        return response()->json([
            'status' => 'success',
            'data'   => $data,
        ]);
    }
}
