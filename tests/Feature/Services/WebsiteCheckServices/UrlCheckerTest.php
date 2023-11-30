<?php

namespace Tests\Feature\Services\WebsiteCheckServices;

use App\Services\WebsiteCheckServices\UrlChecker;
use Exception;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class UrlCheckerTest extends TestCase
{
    public function testCheckWithValidUrl()
    {
        Http::fake([
            '*' => Http::response('', 200),
        ]);

        $urlChecker = new UrlChecker();

        $result = $urlChecker->check('https://example.com');

        $this->assertArrayHasKey('response_status', $result);
        $this->assertArrayHasKey('execution_time', $result);
        $this->assertArrayHasKey('checked_at', $result);
        $this->assertArrayNotHasKey('error_message', $result);

        $this->assertEquals(200, $result['response_status']);

        $this->assertGreaterThanOrEqual(0, $result['execution_time']);

        $this->assertEquals(Date::now()->format('Y-m-d H:i'), $result['checked_at']);
    }

    public function testCheckWithInvalidUrl()
    {
        Http::fake([
            '*' => function () {
                throw new Exception('Invalid URL');
            },
        ]);

        $urlChecker = new UrlChecker();

        $result = $urlChecker->check('invalid-url');

        $this->assertArrayHasKey('error_message', $result);
        $this->assertArrayNotHasKey('response_status', $result);
        $this->assertArrayNotHasKey('execution_time', $result);
        $this->assertArrayNotHasKey('checked_at', $result);

        $this->assertEquals('Invalid URL', $result['error_message']);
    }
}
