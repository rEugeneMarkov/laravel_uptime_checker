<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;

interface ChartDataManipulatorInterface
{
    public function manipulate(Collection $checks): Collection;
}
