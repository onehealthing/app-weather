<?php

namespace App\Http\Services\WeatherClientService;

use Symfony\Component\HttpFoundation\Response;

interface WeatherClientServiceInterface
{
    /**
     * @param string $airports
     * @param string $format
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \App\Exceptions\FormatNotFoundException
     */
    public function getReportResponse(string $airports, string $format): Response;
}
