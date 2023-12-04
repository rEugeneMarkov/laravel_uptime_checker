<?php

namespace App\Providers;

use App\Helpers\DashChartHelper;
use App\Helpers\UptimeChartHelper;
use App\Helpers\WebsiteControllerShowHelper;
use App\Interfaces\ChartDataManipulatorInterface;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->when(WebsiteControllerShowHelper::class)
            ->needs(ChartDataManipulatorInterface::class)
            ->give([
                DashChartHelper::class,
                UptimeChartHelper::class,
            ]);
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
