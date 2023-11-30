<?php

namespace App\Services\NotificationServices;

use App\Mail\WebsiteErrorNotification;
use App\Mail\WebsiteStatusNotification;
use App\Models\CheckError;
use App\Models\CheckWebsiteData;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Mail;

class SendNotification
{
    public function sendErrorNotifications(): void
    {
        $errors = $this->getErrors();

        foreach ($errors as $error) {
            Mail::to($error->website->email)
                ->queue(new WebsiteErrorNotification($error->website->website, $error->error_message));
        }
    }

    public function sendStatusNotifications(): void
    {
        $websitesData = $this->getwebsitesData();
        foreach ($websitesData as $websiteData) {
            $url = $websiteData->website->website;
            $responseStatus = $websiteData->response_status;

            Mail::to($websiteData->website->email)
                ->queue(new WebsiteStatusNotification($url, $responseStatus));
        }
    }

    public function getErrors($subMinutes = 1): Collection
    {
        return CheckError::where('created_at', '>=', now()->subMinutes($subMinutes))->get();
    }

    public function getwebsitesData($subMinutes = 1): Collection
    {
        return CheckWebsiteData::where('created_at', '>=', now()->subMinutes($subMinutes))
            ->where('response_status', '<>', 200)
            ->get();
    }
}
