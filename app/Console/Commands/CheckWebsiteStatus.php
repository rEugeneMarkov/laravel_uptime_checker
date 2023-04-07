<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\WebsiteCheckController;

class CheckWebsiteStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check-site {frequency}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $frequency = $this->argument('frequency');
        $check = new WebsiteCheckController();
        $check->checkWebsite($frequency);
    }
}
