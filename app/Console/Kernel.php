<?php

namespace App\Console;

use App\Models\Website;
use App\Jobs\CheckWebsiteJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $websites = Website::all();

        foreach ($websites as $website) {
            if ($website->status) {
                $schedule->job(new CheckWebsiteJob($website))
                     ->cron("*/{$website->interval} * * * *")
                     ->name("check-website-{$website->id}-{$website->interval}");
            }
        }

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
