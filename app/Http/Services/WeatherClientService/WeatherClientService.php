<?php

namespace App\Http\Services\WeatherClientService;

use App\Exceptions\FormatNotFoundException;
use App\Http\Services\HttpService\HttpServiceInterface;
use App\Http\Services\OutputFormatService\OutputFormatServiceInterface;
use Symfony\Component\HttpFoundation\Response;

class WeatherClientService implements WeatherClientServiceInterface
{
    const WEATHER_CLIENT_ENDPOINT = 'https://tgftp.nws.noaa.gov/data/observations/metar/decoded/%s.TXT';

    /**
     * @param \App\Http\Services\HttpService\HttpServiceInterface $httpService
     * @param \App\Http\Services\OutputFormatService\OutputFormatServiceInterface $outputFormatService
     */
    public function __construct(
        private HttpServiceInterface $httpService,
        private OutputFormatServiceInterface $outputFormatService
    ) {}

    /**
     * @param string $airports
     * @param string $format
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \App\Exceptions\FormatNotFoundException
     */
    public function getReportResponse(string $airports, string $format): Response
    {
        if (!$this->outputFormatService->isFormatAvailable($format)) {
            throw new FormatNotFoundException($format);
        }

        $responseStream = $this->httpService->getAsyncFulfilled(
            $this->generateEndpoints($airports)
        );

        return $this->outputFormatService->format($responseStream, $format);
    }

    /**
     * @param string $airports
     *
     * @return array
     */
    private function generateEndpoints(string $airports): array
    {
        $endpoints = [];

        foreach (explode(',', $airports) as $airport) {
            $endpoints[] = sprintf(self::WEATHER_CLIENT_ENDPOINT, $airport);
        }

        return $endpoints;
    }
}
