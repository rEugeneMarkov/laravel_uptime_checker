<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\Models\CheckWebsiteData;
use Illuminate\Support\Collection;
use App\Interfaces\UptimeChartDataManipulatorInterface;

class UptimeChartHelper implements UptimeChartDataManipulatorInterface
{
    public function manipulate(Collection $checks): array
    {
        $chartData = $this->generateChartData($checks);
        $mergedData = $this->mergeChartData($chartData);
        return array_reverse($mergedData);
    }

    private function generateChartData(Collection $checks): array
    {
        $chartData = [];
        $count = count($checks);

        for ($i = 0; $i < $count; $i++) {
            $check = $checks[$i];
            $nextCheck = $i < $count - 1 ? $checks[$i + 1] : null;

            $status = $this->getStatus($check);
            $chartData[] = [
                'start_time' => Carbon::parse($check->checked_at),
                'end_time' => $nextCheck ? Carbon::parse($nextCheck->checked_at) : Carbon::now(),
                'status' => $status,
            ];
        }

        return $chartData;
    }

    private function getStatus(CheckWebsiteData $check): string
    {
        $timeout = $check->website->timeout * 1000;
        return ($check->response_status === 200 && $check->execution_time <= $timeout) ? 'Up' : 'Down';
    }

    private function mergeChartData(array $chartData): array
    {
        $mergedData = [];
        $previousData = null;

        foreach ($chartData as $data) {
            if ($previousData && $previousData['status'] === $data['status']) {
                $previousData['end_time'] = $data['end_time'];
            } else {
                if ($previousData) {
                    $previousData['duration'] = $this
                        ->calculateDuration($previousData['start_time'], $previousData['end_time']);
                    $mergedData[] = $previousData;
                }

                $previousData = $data;
            }
        }

        if ($previousData) {
            $previousData['duration'] = $this
                ->calculateDuration($previousData['start_time'], $previousData['end_time']);
            $mergedData[] = $previousData;
        }

        return $mergedData;
    }

    private function calculateDuration(Carbon $startTime, Carbon $endTime): int
    {
        return $startTime->diffInMinutes($endTime);
    }
}
