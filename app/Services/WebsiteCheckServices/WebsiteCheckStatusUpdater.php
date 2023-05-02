<?php

namespace App\Services\WebsiteCheckServices;

use App\Models\Website;

abstract class WebsiteCheckStatusUpdater
{
    public static function updateStatus(Website $website): void
    {
        $newStatus = $website->status ? false : true;
        $website->update(['status' => $newStatus]);
    }
}
