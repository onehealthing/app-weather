<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Services\ReportService\ReportServiceInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReportController extends Controller
{
    /**
     * @param \App\Http\Services\ReportService\ReportServiceInterface $reportService
     */
    public function __construct(
        private ReportServiceInterface $reportService
    ) {}

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @OA\Get(
     *     path="/api/report?airports=UKBB,LHBP,LFLL,LFOA,LFBD,LEZG,KJAN,KBOS,CYQT&format=json",
     *     summary="Get weather report",
     *     tags={"report"},
     *     @OA\Response(response=200, description="Successful operation")
     * )
     */
    public function index(Request $request): Response
    {
        try {
            return $this->reportService->generateReport($request);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
}
