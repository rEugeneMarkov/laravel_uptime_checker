<?php

namespace App\Services\NotificationServices;

use App\Models\CheckError;
use App\Models\CheckWebsiteData;
use Illuminate\Support\Facades\Mail;
use App\Mail\WebsiteErrorNotification;
use App\Mail\WebsiteStatusNotification;

class SendNotification
{
    public function sendErrorNotifications(): void
    {
        $errors = CheckError::where('created_at', '>=', now()->subMinutes(1))
            ->get();

        foreach ($errors as $error) {
            Mail::to($error->website->email)
                ->queue(new WebsiteErrorNotification($error->website->website, $error->error_message));
        }
    }

    public function sendStatusNotifications(): void
    {
        $websitesData = CheckWebsiteData::where('created_at', '>=', now()->subMinutes(1))
            ->where('response_status', '<>', 200)
            ->get();
        foreach ($websitesData as $websiteData) {
            $url = $websiteData->website->website;
            $responseStatus = $websiteData->response_status;

            Mail::to($websiteData->website->email)
            ->queue(new WebsiteStatusNotification($url, $responseStatus));
        }
    }
}
