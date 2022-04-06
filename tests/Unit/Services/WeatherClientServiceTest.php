<?php

namespace Tests\Unit\Services;

use App\Exceptions\FormatNotFoundException;
use App\Http\Services\WeatherClientService\WeatherClientServiceInterface;
use PHPUnit\Framework\TestCase;
use Tests\CreatesApplication;

class WeatherClientServiceTest extends TestCase
{
    use CreatesApplication;

    /**
     * @var \App\Http\Services\WeatherClientService\WeatherClientServiceInterface
     */
    private WeatherClientServiceInterface $weatherClientService;

    protected function setUp(): void
    {
        parent::setUp();

        $app = $this->createApplication();
        $this->weatherClientService = $app->make(WeatherClientServiceInterface::class);
    }

    /**
     * @return void
     */
    public function test_generate_report_with_wrong_format()
    {
        $format = 'xml';

        $this->expectException(FormatNotFoundException::class);

        $this->weatherClientService->getReportResponse('', $format);
    }

    /**
     * @return void
     */
    public function test_generate_report_with_correct_format()
    {
        $airports = 'UKBB,LHBP';
        $format = 'raw';

        $reportResponse = $this->weatherClientService->getReportResponse($airports, $format);

        $this->assertEquals(200, $reportResponse->getStatusCode());
        $this->assertEquals('text/plain', $reportResponse->headers->get('Content-Type'));
        $this->assertTrue(strlen($reportResponse->getContent()) > 0);
    }
}
