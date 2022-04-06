<?php

namespace Tests\Unit\Services;

use App\Http\Services\CacheService\CacheServiceInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Tests\CreatesApplication;

class CacheServiceTest extends TestCase
{
    use CreatesApplication;

    const CACHE_KEY = 'data';

    /**
     * @var \App\Http\Services\CacheService\CacheServiceInterface
     */
    private CacheServiceInterface $cacheService;

    /**
     * @var \Symfony\Component\HttpFoundation\Response
     */
    private Response $httpResponse;

    protected function setUp(): void
    {
        parent::setUp();

        $app = $this->createApplication();
        $this->cacheService = $app->make(CacheServiceInterface::class);
        $this->httpResponse = $this->prepareHttpResponse();
    }

    /**
     * @return void
     */
    public function test_put_correct_data()
    {
        $httpResponse = $this->prepareHttpResponse();

        $this->cacheService->put(self::CACHE_KEY, $httpResponse);

        $this->assertTrue(true);
    }

    /**
     * @return void
     */
    public function test_get_correct_data()
    {
        $cache = $this->cacheService->get(self::CACHE_KEY);

        $this->assertEquals($this->httpResponse->getContent(), $cache['content']);
        $this->assertEquals('text/plain', $this->httpResponse->headers->get('Content-type'));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function prepareHttpResponse(): Response
    {
        $string = 'Boryspil, Ukraine (UKBB) 50-20N 030-58E 122M Feb 23, 2022 - 10:30 PM EST /
            2022.02.24 0330 UTC Wind: from the S (190 degrees) at 2 MPH (2 KT):0 Visibility: 3 mile(s):0
            Sky conditions: mostly cloudy Weather: light rain; mist Temperature: 33 F (1 C)
            Dew Point: 33 F (1 C) Relative Humidity: 100% Pressure (altimeter): 30.12 in.
            Hg (1020 hPa) ob: UKBB 240330Z 19001MPS 5000 -RA BR SCT008 BKN016 01/01 Q1020 TEMPO
            1000 BR cycle: 3';

        return new Response($string, 200, [
            'Content-type' => 'text/plain'
        ]);
    }
}
