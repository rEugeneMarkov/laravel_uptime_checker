<?php

namespace App\Helpers;

use App\Interfaces\ChartDataManipulatorInterface;
use App\Models\CheckWebsiteData;
use App\Models\Website;
use Illuminate\Support\Collection;

class WebsiteControllerShowHelper
{
    private array $manipulators;

    public function __construct(
        ChartDataManipulatorInterface ...$manipulators,
    ) {
        $this->manipulators = $manipulators;
    }

    public function getShowData(Website $website): Collection
    {
        $checks = CheckWebsiteData::where('website_id', $website->id)->SubDay()->get();
        $dashChartData = $this->manipulators[0]->manipulate($checks);
        $uptimeChartData = $this->manipulators[1]->manipulate($checks);

        return collect([
            'dashChartData' => $dashChartData->all(),
            'uptimeChartData' => $uptimeChartData->all(),
            'avgExecTime' => $dashChartData->avg('avg_execution_time'),
            'website' => $website,
        ]);
    }
}
