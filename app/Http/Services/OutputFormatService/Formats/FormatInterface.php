<?php

namespace App\Http\Services\OutputFormatService\Formats;

use Symfony\Component\HttpFoundation\Response;

interface FormatInterface
{
    /**
     * @param \GuzzleHttp\Psr7\Response[] $stream
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function format(array $stream): Response;
}
