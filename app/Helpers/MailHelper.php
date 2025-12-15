<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

if (!function_exists('sendCustomMail')) {
    function sendCustomMail(string $to, string $subject, string $htmlContent): bool
    {
        $payload = [
            "from" => [
                "address" => "no-reply@tappayz.com",
                "display_name" => "Tappayz",
            ],
            "to" => [
                [
                    "address" => $to,
                    "display_name" => Auth::user()?->name,
                ]
            ],
            "subject" => $subject,
            "html" => $htmlContent,
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'x-api-key' => Setting::first()->maileroo_api_key ?? '',
            ])->post('https://smtp.maileroo.com/api/v2/emails', $payload);

            if ($response->failed()) {
                Log::error('Maileroo API failed', [
                    'to' => $to,
                    'status' => $response->status(),
                    'response' => $response->body(),
                ]);
                return false;
            }

            return true;

        } catch (\Throwable $e) {
            Log::error('Maileroo API exception', [
                'to' => $to,
                'message' => $e->getMessage(),
            ]);
            return false;
        }
    }
}
