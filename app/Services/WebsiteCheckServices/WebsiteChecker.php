<?php

namespace App\Services\WebsiteCheckServices;

use App\Models\Website;
use App\Models\CheckError;
use App\Models\CheckWebsiteData;
use App\Services\WebsiteCheckServices\WebsiteLogger;

class WebsiteChecker
{
    public function __construct(
        private UrlChecker $checker,
        private WebsiteLogger $logger,
    ) {
    }
    public function checkWebsite(Website $website): void
    {

        $data = $this->checker->check($website->website);
        $data['website_id'] = $website->id;

        $this->safeCheckData($website, $data);
        $this->logger->safeLog($website, $data);
    }

    public function safeCheckData(Website $website, array $data): void
    {
        if (array_key_exists('error_message', $data)) {
            CheckError::create($data);
            WebsiteCheckStatusUpdater::updateStatus($website);
        } else {
            CheckWebsiteData::create($data);
        }
    }
}
