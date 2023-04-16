<?php

namespace App\Services\WebsiteCheckServices;

use Illuminate\Support\Facades\Mail;
use App\Mail\WebsiteStatusNotification;

class WebsiteStatusNotifier
{
    public function sendNotification(string $email, string $url, int $status): void
    {
        Mail::to($email)->queue(new WebsiteStatusNotification($url, $status));
    }
}
