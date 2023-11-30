<?php

namespace App\Console\Commands;

use App\Services\WebsiteCheckServices\CommandService;
use Illuminate\Console\Command;

class CheckWebsite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-website';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(CommandService $service): void
    {
        $service->handle();
    }
}
