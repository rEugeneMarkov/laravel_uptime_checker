<?php

namespace App\Jobs;

use Exception;
use App\Models\Website;
use Illuminate\Bus\Queueable;
use App\Jobs\SendStatusMailJob;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\WebsiteErrorNotification;
use Illuminate\Queue\SerializesModels;
use App\Mail\WebsiteStatusNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Http\Controllers\WebsiteCheckController;

class CheckWebsiteJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private $website;

    /**
     * Create a new job instance.
     */
    public function __construct($website)
    {
        $this->website = $website;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $response = Http::get($this->website->website);
            if ($response->status() !== 200) {
                Mail::to($this->website->email)->send(new WebsiteStatusNotification($this->website->website, $response->status()));
            }
        } catch (Exception $exception) {
            $message = $exception->getMessage();
            //echo($message);
            //$statusCode = $exception->getCode();
            Mail::to($this->website->email)->send(new WebsiteErrorNotification($this->website->website, $message));
        }
    }
}
