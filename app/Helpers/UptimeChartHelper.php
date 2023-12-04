<?php

namespace App\Helpers;

use App\Interfaces\ChartDataManipulatorInterface;
use App\Models\CheckWebsiteData;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class UptimeChartHelper implements ChartDataManipulatorInterface
{
    public function manipulate(Collection $checks): Collection
    {
        return $this->chartData($checks)->reverse();
    }

    private function chartData(Collection $checks)
    {
        $chartData = [];
        $last = [];

        foreach ($checks as $check) {
            $status = $this->getStatus($check);

            $current = [
                'start_time' => Carbon::parse($check->checked_at),
                'status' => $status,
            ];

            if (empty($last)) {
                $last = $current;
                continue;
            }

            if ($current['status'] == $last['status']) {
                continue;
            }

            $last['end_time'] = $current['start_time'];
            $last['duration'] = $this->calculateDuration($last);

            $chartData[] = $last;
            $last = $current;
        }

        if ($checks->isNotEmpty()) {
            $last['end_time'] = Carbon::now();
            $last['duration'] = $this->calculateDuration($last);

            $chartData[] = $last;
        }

        return collect($chartData);
    }

    private function getStatus(CheckWebsiteData $check): string
    {
        $timeout = $check->website->timeout * 1000;

        return ($check->response_status === 200 && $check->execution_time <= $timeout) ? 'Up' : 'Down';
    }

    private function calculateDuration(array $last): int
    {
        return $last['start_time']->diffInMinutes($last['end_time']);
    }
}
