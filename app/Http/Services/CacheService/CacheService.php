<?php

namespace App\Http\Services\CacheService;

use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class CacheService implements CacheServiceInterface
{
    private const TTL = 3600;

    /**
     * @param string $key
     * @param \Symfony\Component\HttpFoundation\Response $response
     *
     * @return void
     */
    public function put(string $key, Response $response): void
    {
        Cache::put($key, $this->prepareStorageData($response), self::TTL);
    }

    /**
     * @param $key
     *
     * @return ?array
     */
    public function get($key): ?array
    {
        return Cache::get($key);
    }

    /**
     * @param Response $response
     *
     * @return array
     */
    protected function prepareStorageData(Response $response): array
    {
        return [
            'content' => $response->getContent(),
            'content-type' => $response->headers->get('Content-Type')
        ];
    }
}
