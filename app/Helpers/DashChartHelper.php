<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use App\Interfaces\DashChartDataManipulatorInterface;

class DashChartHelper implements DashChartDataManipulatorInterface
{
    public function manipulate(Collection $checks): array
    {
        $data = $checks->groupBy(function ($check) {
            return Carbon::parse($check->checked_at)->hour;
        })->map(function ($group) {
            return [
                'hour' => (int) Carbon::parse($group->first()->checked_at)->format('H'),
                'avg_execution_time' => $group->avg('execution_time'),
            ];
        })->sortBy('hour')->values();

        return $data->toArray();
    }
}
