<?php

namespace App\Services\WebsiteCheckServices;

use App\Jobs\CheckWebsiteJob;
use App\Models\Website;

class CommandService
{
    public function handle(): void
    {
        $websites = Website::active()->forCheck()->get();

        foreach ($websites as $website) {
            CheckWebsiteJob::dispatch($website);
        }
    }
}
