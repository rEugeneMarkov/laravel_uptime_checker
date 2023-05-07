<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotificationServices\SendNotification;

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
    public function handle(SendNotification $notification)
    {
        $notification->sendErrorNotifications();
        $notification->sendStatusNotifications();
    }
}
