<?php

namespace App\Http\Services\CacheService;

use Symfony\Component\HttpFoundation\Response;

interface CacheServiceInterface
{
    /**
     * @param string $key
     * @param \Symfony\Component\HttpFoundation\Response $response
     *
     * @return void
     */
    public function put(string $key, Response $response): void;

    /**
     * @param $key
     *
     * @return ?array
     */
    public function get($key): ?array;
}
