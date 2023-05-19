<?php

namespace App\Services\WebsiteCheckServices;

use App\Models\Website;
use Illuminate\Support\Facades\Log;

class WebsiteLogger
{
    public function safeLog(Website $website, array $data): void
    {
        if (array_key_exists('error_message', $data)) {
            $this->logError($website->website, $data['error_message']);
        } elseif ($data['response_status'] !== 200) {
            $this->logWarning($website->website, $data['response_status']);
        } else {
            $this->logInfo($website->website);
        }
    }

    public function logInfo(string $url): void
    {
        Log::channel('site_checks')->info('Website ' . $url . ' is accessible');
    }

    public function logWarning(string $url, int $status): void
    {
        Log::channel('site_checks')->warning('Website ' . $url . ' is not accessible with status code: ' . $status);
    }

    public function logError(string $url, string $message): void
    {
        Log::channel('site_checks')->error('Website ' . $url . ' is not accessible with error: ' . $message);
    }
}
