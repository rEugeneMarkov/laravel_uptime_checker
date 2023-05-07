<?php

namespace App\Services\WebsiteCheckServices;

use App\Models\Website;

abstract class WebsiteCheckStatusUpdater
{
    public static function updateStatus(Website $website): void
    {
        $newStatus = $website->monitoring_status ? false : true;
        $website->update(['monitoring_status' => $newStatus]);
    }
}
