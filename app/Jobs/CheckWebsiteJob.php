<?php

namespace App\Jobs;

use App\Models\Website;
use App\Services\WebsiteCheckServices\JobService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\WebsiteCheckServices\WebsiteChecker;

class CheckWebsiteJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private Website $website)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(WebsiteChecker $checker): void
    {
        $checker->checkWebsite($this->website);
    }
}
