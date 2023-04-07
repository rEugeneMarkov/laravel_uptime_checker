<?php

namespace App\Http\Controllers;

use App\Models\Website;
use App\Jobs\CheckWebsiteJob;

class WebsiteCheckController extends Controller
{
    public function checkWebsite(int $frequencyId): void
    {
        $websites = Website::where('frequency_id', '=', $frequencyId)
            ->where('status', '=', 'Active')
            ->get();
        foreach ($websites as $website) {
            CheckWebsiteJob::dispatch($website);
        }
    }
}
