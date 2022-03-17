<?php

namespace App\Http\Services\ReportService;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

interface ReportServiceInterface
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \App\Exceptions\FormatNotFoundException
     */
    public function generateReport(Request $request): Response;
}
