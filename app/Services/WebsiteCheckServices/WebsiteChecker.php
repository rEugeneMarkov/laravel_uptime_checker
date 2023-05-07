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
        private ?Website $website = null,
    ) {
    }
    public function checkWebsite(Website $website): void
    {
        $this->website = $website;

        $data = $this->checker->check($website->website);
        $data['website_id'] = $website->id;

        $this->safeCheckData($data);
        $this->safeLog($data);
    }

    public function safeLog(array $data): void
    {
        if (array_key_exists('error_message', $data)) {
            $this->logger->logError($this->website->website, $data['error_message']);
        } elseif ($data['response_status'] !== 200) {
            $this->logger->logWarning($this->website->website, $data['response_status']);
        } else {
            $this->logger->logInfo($this->website->website);
        }
    }
    public function safeCheckData(array $data): void
    {
        if (array_key_exists('error_message', $data)) {
            CheckError::create($data);
            WebsiteCheckStatusUpdater::updateStatus($this->website);
        } else {
            CheckWebsiteData::create($data);
        }
    }
}
