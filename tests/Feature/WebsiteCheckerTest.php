<?php

namespace Tests\Feature;

use App\Models\CheckError;
use App\Models\CheckWebsiteData;
use App\Models\Website;
use App\Services\WebsiteCheckServices\UrlChecker;
use App\Services\WebsiteCheckServices\WebsiteChecker;
use App\Services\WebsiteCheckServices\WebsiteLogger;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\MockObject\Exception;
use Tests\TestCase;

class WebsiteCheckerTest extends TestCase
{
    use RefreshDatabase;
    private WebsiteChecker $websiteChecker;
    private UrlChecker $urlCheckerMock;
    private WebsiteLogger $websiteLoggerMock;

    protected function setUp(): void
    {
        $this->urlCheckerMock = $this->createMock(UrlChecker::class);
        $this->websiteLoggerMock = $this->createMock(WebsiteLogger::class);
        $this->websiteChecker = new WebsiteChecker($this->urlCheckerMock, $this->websiteLoggerMock);
    }

    public function test_check_website_with_error_message(): void
    {
        $this->withoutExeptionHeadlink;

        $website = new Website();
        $website->website = 'https://example.com';

        $data = ['error_message' => 'Invalid URL'];
        $this->urlCheckerMock->expects($this->once())
            ->method('check')
            ->with('https://example.com')
            ->willReturn($data);

        $this->websiteLoggerMock->expects($this->never())
            ->method('safeLog');

        $this->websiteChecker->checkWebsite($website);

        $this->assertTrue(CheckError::where($data)->exists());
        $this->assertFalse(CheckWebsiteData::where($data)->exists());
    }

    public function test_CheckWebsiteWithoutErrorMessage(): void
    {
        $website = new Website();
        $website->website = 'https://example.com';

        $data = ['title' => 'Example Website'];
        $this->urlCheckerMock->expects($this->once())
            ->method('check')
            ->with('https://example.com')
            ->willReturn($data);

        $this->websiteLoggerMock->expects($this->once())
            ->method('safeLog')
            ->with($website, $data);

        $this->websiteChecker->checkWebsite($website);

        $this->assertFalse(CheckError::where($data)->exists());
        $this->assertTrue(CheckWebsiteData::where($data)->exists());
    }

    // Add more test cases as needed
}

