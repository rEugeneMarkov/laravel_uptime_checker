<?php

namespace App\Console\Commands;

use App\Services\NotificationServices\SendNotification;
use Illuminate\Console\Command;

class SendNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(SendNotification $notification): void
    {
        $notification->sendErrorNotifications();
        $notification->sendStatusNotifications();
    }
}
