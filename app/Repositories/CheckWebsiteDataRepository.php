<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Website;
use App\Models\CheckWebsiteData;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CheckWebsiteDataRepository
{
    public function getChecksSubDay(int $id): Collection
    {
        $checks = CheckWebsiteData::where('website_id', $id)
            ->where('checked_at', '>=', Carbon::now()->subDay())
            ->orderBy('checked_at')
            ->get();

        return $checks;
    }
    public function getWebsitesForCheck(): Collection
    {
        $websites = Website::where('monitoring_status', true)
            ->whereDoesntHave('checkData')
            ->orWhereHas('checkData', function ($query) {
                $query->select(DB::raw('MAX(checked_at) as last_checked_at'))
                    ->havingRaw('last_checked_at <= NOW() - INTERVAL websites.interval MINUTE');
            })
            ->get();
        return $websites;
    }
}
