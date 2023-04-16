<?php

namespace App\Services\WebsiteCheckServices;

use Illuminate\Support\Facades\Log;

class WebsiteLogger
{
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
