<?php

namespace App\Services\WebsiteCheckServices;

use App\Models\Website;
use App\Jobs\CheckWebsiteJob;
use Illuminate\Support\Facades\DB;
use App\Repositories\CheckWebsiteDataRepository;

class CommandService
{
    public function __construct(
        private CheckWebsiteDataRepository $checkWebsiteDataRepository
    ) {
    }
    public function handle(): void
    {
        $websites =  $this->checkWebsiteDataRepository->getWebsitesForCheck();

        foreach ($websites as $website) {
            CheckWebsiteJob::dispatch($website);
        }
    }
}
