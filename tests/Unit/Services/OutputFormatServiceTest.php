<?php

namespace Tests\Unit\Services;

use App\Http\Services\OutputFormatService\OutputFormatServiceInterface;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Tests\CreatesApplication;

class OutputFormatServiceTest extends TestCase
{
    use CreatesApplication;

    /**
     * @var \App\Http\Services\OutputFormatService\OutputFormatServiceInterface
     */
    private OutputFormatServiceInterface $outputFormatService;

    protected function setUp(): void
    {
        parent::setUp();

        $app = $this->createApplication();

        $this->outputFormatService = $app->make(OutputFormatServiceInterface::class);
    }

    /**
     * @return void
     */
    public function test_wrong_format_type()
    {
        $wrongFormatType = 'xml';

        $isFormatAvailable = $this->outputFormatService->isFormatAvailable($wrongFormatType);

        $this->assertEquals(false, $isFormatAvailable);
    }

    /**
     * @return void
     */
    public function test_correct_format_type()
    {
        $wrongFormatType = 'raw';

        $isFormatAvailable = $this->outputFormatService->isFormatAvailable($wrongFormatType);

        $this->assertEquals(true, $isFormatAvailable);
    }

    public function test_format_response_raw()
    {
        $guzzleHttpResponse = $this->prepareGuzzleHttpResponse();

        $response = $this->outputFormatService->format([$guzzleHttpResponse], 'raw');

        $this->assertEquals('text/plain', $response->headers->get('Content-Type'));

        $this->assertEquals(
            $this->clearStringFrom(PHP_EOL, $guzzleHttpResponse->getBody()),
            $this->clearStringFrom(PHP_EOL, $response->getContent())
        );
    }

    public function test_format_response_json()
    {
        $guzzleHttpResponse = $this->prepareGuzzleHttpResponse();

        $response = $this->outputFormatService->format([$guzzleHttpResponse], 'json');

        $this->assertEquals('application/json', $response->headers->get('Content-Type'));

        $this->assertEquals(
            $guzzleHttpResponse->getBody(),
            json_decode($response->getContent())
        );
    }

    public function test_format_response_pdf()
    {
        $guzzleHttpResponse = $this->prepareGuzzleHttpResponse();

        $response = $this->outputFormatService->format([$guzzleHttpResponse], 'pdf');

        $this->assertEquals('application/pdf', $response->headers->get('Content-Type'));

        $this->assertIsString($response->getContent());
    }

    public function test_format_response_html()
    {
        $guzzleHttpResponse = $this->prepareGuzzleHttpResponse();

        $response = $this->outputFormatService->format([$guzzleHttpResponse], 'html');

        $this->assertEquals('text/html', $response->headers->get('Content-Type'));

        $this->assertEquals(
            $guzzleHttpResponse->getBody(),
            $this->clearStringFrom('<p></p>', $response->getContent())
        );
    }

    /**
     * @return \GuzzleHttp\Psr7\Response
     */
    private function prepareGuzzleHttpResponse(): Response
    {
        $string = 'Boryspil, Ukraine (UKBB) 50-20N 030-58E 122M Feb 23, 2022 - 10:30 PM EST /
            2022.02.24 0330 UTC Wind: from the S (190 degrees) at 2 MPH (2 KT):0 Visibility: 3 mile(s):0
            Sky conditions: mostly cloudy Weather: light rain; mist Temperature: 33 F (1 C)
            Dew Point: 33 F (1 C) Relative Humidity: 100% Pressure (altimeter): 30.12 in.
            Hg (1020 hPa) ob: UKBB 240330Z 19001MPS 5000 -RA BR SCT008 BKN016 01/01 Q1020 TEMPO
            1000 BR cycle: 3';

        return new Response(200, [], $string);
    }

    /**
     * @param string $search
     * @param string $str
     *
     * @return array|string
     */
    private function clearStringFrom(string $search, string $str): array|string
    {
        return str_replace($search, '', $str);
    }
}
