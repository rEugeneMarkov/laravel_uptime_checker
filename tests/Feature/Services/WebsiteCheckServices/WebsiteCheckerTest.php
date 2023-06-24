<?php

namespace Tests\Feature\Services\WebsiteCheckServices;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\WebsiteCheckServices\WebsiteChecker;
use App\Services\WebsiteCheckServices\UrlChecker;
use App\Services\WebsiteCheckServices\WebsiteLogger;
use App\Models\Website;
use App\Models\CheckError;
use App\Models\CheckWebsiteData;
use App\Services\WebsiteCheckServices\WebsiteCheckStatusUpdater;

class WebsiteCheckerTest extends TestCase
{
    use RefreshDatabase;

    public function testCheckWebsiteWithError()
    {
        $this->withoutExceptionHandling();

        $urlChecker = $this->createMock(UrlChecker::class);
        $urlChecker->expects($this->once())
            ->method('check')
            ->willReturn(['error_message' => 'Some error message']);

        $websiteLogger = $this->createMock(WebsiteLogger::class);

        $websiteChecker = new WebsiteChecker($urlChecker, $websiteLogger);

        $website = Website::factory()->create();

        $websiteChecker->checkWebsite($website);

        $this->assertDatabaseHas('check_errors', [
            'error_message' => 'Some error message',
            'website_id' => $website->id
        ]);
    }

    public function testCheckWebsiteWithoutError()
    {
        $this->withoutExceptionHandling();

        $urlChecker = $this->createMock(UrlChecker::class);
        $urlChecker->expects($this->once())
            ->method('check')
            ->willReturn([
                'response_status' => 200,
                'execution_time' => 2,
                'checked_at' => '2023-06-06 20:00'
            ]);

        $websiteLogger = $this->createMock(WebsiteLogger::class);

        $websiteChecker = new WebsiteChecker($urlChecker, $websiteLogger);

        $website = Website::factory()->create();

        $websiteChecker->checkWebsite($website);

        $this->assertDatabaseHas('check_website_data', [
            'response_status' => 200,
            'execution_time' => 2,
            'checked_at' => '2023-06-06 20:00',
            'website_id' => $website->id
        ]);
    }
}
