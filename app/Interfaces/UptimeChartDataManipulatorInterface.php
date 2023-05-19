<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;

interface UptimeChartDataManipulatorInterface
{
    public function manipulate(Collection $checks): array;
}
