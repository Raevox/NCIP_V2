<?php
// app/Services/SmsService.php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    public function send(string $number, string $message): bool
    {
        $response = Http::withHeaders([
                'x-api-key' => config('services.textbee.api_key'),
            ])
            ->post(config('services.textbee.api_url'), [
                'recipients' => [$number],
                'message'    => $message,
            ]);

        if ($response->failed()) {
            Log::error('TextBee SMS failed', [
                'number' => $number,
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            return false;
        }

        return true;
    }
}

