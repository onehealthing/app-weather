<?php

namespace App\Http\Services\ReportService;

use App\Http\Services\CacheService\CacheServiceInterface;
use App\Http\Services\WeatherClientService\WeatherClientServiceInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReportService implements ReportServiceInterface
{
    /**
     * @param \App\Http\Services\WeatherClientService\WeatherClientServiceInterface $weatherClientService
     * @param \App\Http\Services\CacheService\CacheServiceInterface $cacheService
     */
    public function __construct(
        private WeatherClientServiceInterface $weatherClientService,
        private CacheServiceInterface $cacheService
    ) {}

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \App\Exceptions\FormatNotFoundException
     */
    public function generateReport(Request $request): Response
    {
        $airports = $request->get('airports', '');
        $format = $request->get('format', 'raw');

        if ($cache = $this->cacheService->get("$format:$airports")) {
            return new Response($cache['content'], 200, [
                'Content-Type' => $cache['content-type']
            ]);
        }

        $report = $this->weatherClientService->getReportResponse($airports, $format);

        $this->cacheService->put("$format:$airports", $report);

        return $report;
    }
}
