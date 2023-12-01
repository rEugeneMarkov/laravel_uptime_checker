<?php

namespace App\Helpers;

use App\Interfaces\DashChartDataManipulatorInterface;
use App\Interfaces\UptimeChartDataManipulatorInterface;
use App\Models\CheckWebsiteData;
use App\Models\Website;

class WebsiteControllerShowHelper
{
    public function __construct(
        private DashChartDataManipulatorInterface $dashChartManipulator,
        private UptimeChartDataManipulatorInterface $uptimeChartManipulator,
    ) {
    }

    public function getShowData(Website $website): array
    {
        $checks = CheckWebsiteData::where('website_id', $website->id)->SubDay()->get();
        $dashChartData = $this->dashChartManipulator->manipulate($checks);
        $uptimeChartData = $this->uptimeChartManipulator->manipulate($checks);

        return [
            'dashChartData' => $dashChartData,
            'uptimeChartData' => $uptimeChartData,
            'avgExecTime' => collect($dashChartData)->avg('avg_execution_time'),
            'website' => $website,
        ];
    }
}
