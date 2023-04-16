<?php

namespace App\Services\WebsiteCheckServices;

use App\Models\Website;

abstract class WebsiteCheckStatusUpdater
{
    public static function updateStatus(Website $website): void
    {
        $newStatus = $website->status == 'Active' ? 'Disabled' : 'Active';
        $website->update(['status' => $newStatus]);
    }
}
