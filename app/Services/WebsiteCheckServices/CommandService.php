<?php

namespace App\Services\WebsiteCheckServices;

use App\Models\Website;
use App\Jobs\CheckWebsiteJob;
use Illuminate\Support\Facades\DB;

class CommandService
{
    public function handle(): void
    {
        $websites = Website::where('monitoring_status', true)
            ->whereDoesntHave('checkData')
            ->orWhereHas('checkData', function ($query) {
                $query->select(DB::raw('MAX(checked_at) as last_checked_at'))
                    ->havingRaw('last_checked_at <= NOW() - INTERVAL websites.interval MINUTE');
            })
            ->get();

        foreach ($websites as $website) {
            CheckWebsiteJob::dispatch($website);
        }
    }
}
