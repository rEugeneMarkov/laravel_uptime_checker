<?php

namespace App\Services\WebsiteCheckServices;

use App\Models\Website;
use App\Jobs\CheckWebsiteJob;
use Illuminate\Database\Query\Builder;

class CommandService
{
    public function handle(): void
    {
        $websites = Website::whereExists(function (Builder $query) {
            $query->from('check_website_data')
                ->whereColumn('websites.id', 'check_website_data.website_id')
                ->whereRaw('checked_at = (SELECT MAX(checked_at) FROM check_website_data 
                    WHERE website_id = websites.id)')
                ->whereRaw('checked_at <= DATE_SUB(NOW(), INTERVAL `interval` MINUTE)');
        })
            ->orWhereDoesntHave('checkData')
            ->where('monitoring_status', true)
            ->get();

        foreach ($websites as $website) {
            CheckWebsiteJob::dispatch($website);
        }
    }
}
