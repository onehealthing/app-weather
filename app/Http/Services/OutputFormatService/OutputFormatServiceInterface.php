<?php

namespace App\Http\Services\OutputFormatService;

use Symfony\Component\HttpFoundation\Response;

interface OutputFormatServiceInterface
{
    /**
     * @param string $format
     *
     * @return bool
     */
    public function isFormatAvailable(string $format): bool;

    /**
     * @param array $data
     * @param string $format
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function format(array $data, string $format): Response;
}
