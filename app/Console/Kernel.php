<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('check-site 1')->everyMinute();
        $schedule->command('check-site 2')->everyFiveMinutes();
        $schedule->command('check-site 3')->everyTenMinutes();
        $schedule->command('check-site 4')->everyThirtyMinutes();
        $schedule->command('check-site 5')->hourly();
        $schedule->command('check-site 6')->daily();
        $schedule->command('check-site 7')->weekly();
        $schedule->command('check-site 8')->monthly();
        $schedule->command('check-site 9')->quarterly();
        $schedule->command('check-site 10')->yearly();

        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
