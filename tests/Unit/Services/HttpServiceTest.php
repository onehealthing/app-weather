<?php

namespace Tests\Unit\Services;

use App\Http\Services\HttpService\HttpServiceInterface;
use PHPUnit\Framework\TestCase;
use Tests\CreatesApplication;

class HttpServiceTest extends TestCase
{
    use CreatesApplication;

    /**
     * @var \App\Http\Services\HttpService\HttpServiceInterface
     */
    private HttpServiceInterface $httpService;

    protected function setUp(): void
    {
        parent::setUp();

        $app = $this->createApplication();
        $this->httpService = $app->make(HttpServiceInterface::class);
    }

    /**
     * @return void
     */
    public function test_receive_correct_data()
    {
        $endpoints = [
            'https://tgftp.nws.noaa.gov/data/observations/metar/decoded/LHBP.TXT'
        ];

        $responseString = "Budapest/Ferihegy,Hungary(LHBP)47-26N019";

        $responseStreams = $this->httpService->getAsyncFulfilled($endpoints);

        $this->assertStringContainsString(
            $this->clearStringFromAllWhitespaces($responseString),
            $this->clearStringFromAllWhitespaces($responseStreams[0]->getBody()->getContents())
        );
    }

    /**
     * @param string $str
     *
     * @return array|string|null
     */
    private function clearStringFromAllWhitespaces(string $str): array|string|null
    {
        return preg_replace('/\s+/', '', $str);
    }
}
