<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;

interface DashChartDataManipulatorInterface
{
    public function manipulate(Collection $checks): array;
}
