<?php

namespace App\Services\WebsiteCheckServices;

use Exception;
use Illuminate\Support\Facades\Http;

class UrlChecker
{
    public function check(string $url): array
    {
        try {
            $start_time = microtime(true);
            $response = Http::get($url);
            $end_time = microtime(true);
            $execution_time = $end_time - $start_time;
            $execution_time *= 1000;

            $data = [
                'response_status' => $response->status(),
                'execution_time' => $execution_time,
                'checked_at' => now()->format('Y-m-d H:i'),
            ];
        } catch (Exception $exception) {
            $data['error_message'] = $exception->getMessage();
        }
        return $data;
    }
}
