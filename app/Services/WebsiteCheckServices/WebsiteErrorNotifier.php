<?php

namespace App\Services\WebsiteCheckServices;

use Illuminate\Support\Facades\Mail;
use App\Mail\WebsiteErrorNotification;

class WebsiteErrorNotifier
{
    public function sendNotification(string $email, string $url, string $message): void
    {
        Mail::to($email)->queue(new WebsiteErrorNotification($url, $message));
    }
}
