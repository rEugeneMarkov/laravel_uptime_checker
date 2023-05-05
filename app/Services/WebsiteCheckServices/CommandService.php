<?php

namespace App\Services\WebsiteCheckServices;

use App\Models\Website;
use App\Jobs\CheckWebsiteJob;

class CommandService
{
    public function handle(): void
    {
        $websites = Website::whereExists(function ($query) {
            $query->from('check_website_data')
                ->whereColumn('websites.id', 'check_website_data.website_id')
                ->whereRaw('checked_at <= DATE_SUB(NOW(), INTERVAL `interval` MINUTE)');
        })
            ->get();

        foreach ($websites as $website) {
            if ($website->status) {
                CheckWebsiteJob::dispatch($website);
            }
        }
    }
}
