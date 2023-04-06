<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Website;
use Illuminate\Http\Request;
use App\Jobs\CheckWebsiteJob;
use App\Jobs\SendStatusMailJob;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\WebsiteStatusNotification;

class WebsiteCheckController extends Controller
{
    public function checkWebsiteStatus()
    {
        $websites = Website::all();
        foreach ($websites as $website) {
            CheckWebsiteJob::dispatch($website);
        }
    }
}
