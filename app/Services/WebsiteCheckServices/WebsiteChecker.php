<?php

namespace App\Services\WebsiteCheckServices;

use Exception;
use App\Models\Website;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use App\Services\WebsiteCheckServices\WebsiteLogger;
use App\Services\WebsiteCheckServices\WebsiteErrorNotifier;
use App\Services\WebsiteCheckServices\WebsiteStatusNotifier;
use App\Services\WebsiteCheckServices\WebsiteCheckStatusUpdater;

class WebsiteChecker
{
    public function checkWebsite(Website $website)
    {
        $url = $website->website;
        $email = $website->email;

        try {
            $response = Http::get($url);
            if ($response->status() !== 200) {
                (new WebsiteStatusNotifier())->sendNotification($email, $url, $response->status());
                (new WebsiteLogger())->logWarning($url, $response->status());
                WebsiteCheckStatusUpdater::updateStatus($website);
            } else {
                (new WebsiteLogger())->logInfo($url);
            }
        } catch (Exception $exception) {
            $eMessage = $exception->getMessage();
            (new WebsiteErrorNotifier())->sendNotification($email, $url, $eMessage);
            (new WebsiteLogger())->logError($url, $eMessage);
            WebsiteCheckStatusUpdater::updateStatus($website);
        }
    }
}
