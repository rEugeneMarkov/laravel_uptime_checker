<?php

namespace App\Http\Helpers;

use App\Models\Website;
use Illuminate\Support\Facades\DB;

class ShowHelper
{
    public function getData(Website $website): array
    {
        $startTime = now()->subDay();
        $endTime = now();

        $data = DB::table('check_website_data')
            ->where('website_id', $website->id)
            ->select(DB::raw('HOUR(checked_at) as hour'), DB::raw('AVG(execution_time) as avg_execution_time'))
            ->whereBetween('checked_at', [$startTime, $endTime])
            ->groupBy(DB::raw('HOUR(checked_at)'))
            ->orderBy('hour', 'asc')
            ->get();

        $chartData = [];
        foreach ($data as $item) {
            $chartData[] = [$item->hour, $item->avg_execution_time];
        }
        return $chartData;
    }
}
