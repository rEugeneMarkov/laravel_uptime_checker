<?php

namespace App\Services\WebsiteCheckServices;

use App\Models\CheckWebsiteData;
use Exception;
use App\Models\Website;
use Illuminate\Support\Facades\Http;
use App\Services\WebsiteCheckServices\WebsiteLogger;
use App\Services\WebsiteCheckServices\WebsiteErrorNotifier;
use App\Services\WebsiteCheckServices\WebsiteStatusNotifier;

class WebsiteChecker
{
    public function checkWebsite(Website $website)
    {
        $url = $website->website;
        $email = $website->email;

        try {
            $start_time = microtime(true);
            $response = Http::get($url);
            $end_time = microtime(true);
            $execution_time = $end_time - $start_time;

            $data = ['website_id' => $website->id,
                    'status' => $response->status(),
                    'execution_time' => $execution_time,
                    'checked_at' => now()->format('Y-m-d H:i'),
                ];
            CheckWebsiteData::create($data);

            if ($response->status() !== 200) {
                (new WebsiteStatusNotifier())->sendNotification($email, $url, $response->status());
                (new WebsiteLogger())->logWarning($url, $response->status());
            } else {
                (new WebsiteLogger())->logInfo($url);
            }
        } catch (Exception $exception) {
            $eMessage = $exception->getMessage();

            $data = ['website_id' => $website->id,
                    'status' => 0,
                    'execution_time' => 0,
                    'checked_at' => now()->format('Y-m-d H:i'),
                ];
            CheckWebsiteData::create($data);

            (new WebsiteErrorNotifier())->sendNotification($email, $url, $eMessage);
            (new WebsiteLogger())->logError($url, $eMessage);
        }
    }
}
