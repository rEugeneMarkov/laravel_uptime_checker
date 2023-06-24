<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use App\Helpers\DashChartHelper;
use App\Helpers\UptimeChartHelper;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\DashChartDataManipulatorInterface;
use App\Interfaces\UptimeChartDataManipulatorInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(DashChartDataManipulatorInterface::class, DashChartHelper::class);
        $this->app->bind(UptimeChartDataManipulatorInterface::class, UptimeChartHelper::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        Paginator::useBootstrapFour();
    }
}
