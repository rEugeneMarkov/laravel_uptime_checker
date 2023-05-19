<?php

namespace App\Helpers;

use App\Models\Website;
use App\Repositories\CheckWebsiteDataRepository;
use App\Interfaces\DashChartDataManipulatorInterface;
use App\Interfaces\UptimeChartDataManipulatorInterface;

class WebsiteControllerShowHelper
{
    public function __construct(
        private DashChartDataManipulatorInterface $dashChartManipulator,
        private UptimeChartDataManipulatorInterface $uptimeChartManipulator,
        private CheckWebsiteDataRepository $checkWebsiteDataRepository
    ) {
    }

    public function getShowData(Website $website): array
    {
        $checks = $this->checkWebsiteDataRepository->getChecksSubDay($website->id);
        $dashChartData = $this->dashChartManipulator->manipulate($checks);
        $uptimeChartData = $this->uptimeChartManipulator->manipulate($checks);

        return [
            'dashChartData' => $dashChartData,
            'uptimeChartData' => $uptimeChartData,
            'avg_execution_time' => collect($dashChartData)->avg('avg_execution_time'),
        ];
    }
}
