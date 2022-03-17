<?php

namespace App\Http\Services\HttpService;

interface HttpServiceInterface
{
    /**
     * @param array $endpoints
     *
     * @return \GuzzleHttp\Psr7\Response[]
     */
    public function getAsyncFulfilled(array $endpoints): array;
}
