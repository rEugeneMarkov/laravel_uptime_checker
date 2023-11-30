<?php

namespace App\Jobs;

use App\Models\Website;
use App\Services\WebsiteCheckServices\WebsiteChecker;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckWebsiteJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly Website $website)
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
