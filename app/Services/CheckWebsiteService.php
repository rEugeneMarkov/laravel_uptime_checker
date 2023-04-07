<?php

namespace App\Services;

use Exception;
use App\Models\Website;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\WebsiteErrorNotification;
use App\Mail\WebsiteStatusNotification;

class CheckWebsiteService
{
    private Website $website;

    public function __construct(Website $website)
    {
        $this->website = $website;
    }

    public function handle(): void
    {
        try {
            $response = Http::get($this->website->website);
            if ($response->status() !== 200) {
                Mail::to($this->website->email)
                    ->send(new WebsiteStatusNotification($this->website->website, $response->status()));
                    self::chengeCheckStatus();
            }
        } catch (Exception $exception) {
            $message = $exception->getMessage();
            Mail::to($this->website->email)
                ->send(new WebsiteErrorNotification($this->website->website, $message));
            self::chengeCheckStatus();
        }
    }

    public function chengeCheckStatus(): void
    {
        if ($this->website->status == 'Active') {
            $this->website->update(['status' => 'Disabled']);
        } else {
            $this->website->update(['status' => 'Active']);
        }
    }
}
