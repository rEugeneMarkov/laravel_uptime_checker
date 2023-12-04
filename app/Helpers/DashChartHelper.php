<?php

namespace App\Helpers;

use App\Interfaces\ChartDataManipulatorInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class DashChartHelper implements ChartDataManipulatorInterface
{
    public function manipulate(Collection $checks): Collection
    {
        $data = $checks->groupBy(function ($check) {
            return Carbon::parse($check->checked_at)->hour;
        })->map(function ($group) {
            return [
                'hour' => (int) Carbon::parse($group->first()->checked_at)->format('H'),
                'avg_execution_time' => $group->avg('execution_time'),
            ];
        })->values();

        return $data;
    }
}
