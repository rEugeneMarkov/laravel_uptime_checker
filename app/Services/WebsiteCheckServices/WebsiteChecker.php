<?php

namespace App\Services\WebsiteCheckServices;

use App\Models\CheckError;
use App\Models\CheckWebsiteData;
use App\Models\Website;

class WebsiteChecker
{
    public function __construct(
        private readonly UrlChecker $checker,
        private readonly WebsiteLogger $logger,
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
            WebsiteCheckStatusUpdater::updateStatusToFalse($website);
        } else {
            CheckWebsiteData::create($data);
        }
    }
}
