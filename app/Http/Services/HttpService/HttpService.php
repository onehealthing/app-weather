<?php

namespace App\Http\Services\HttpService;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\Utils;

class HttpService implements HttpServiceInterface
{
    /**
     * @param \GuzzleHttp\Client $client
     */
    public function __construct(
        private Client $client
    ) {}

    /**
     * @param array $endpoints
     *
     * @return \GuzzleHttp\Psr7\Response[]
     */
    public function getAsyncFulfilled(array $endpoints): array
    {
        $promises = [];
        $fulfilledResponses = [];

        foreach ($endpoints as $endpoint) {
            $promises[] = $this->client->getAsync($endpoint);
        }

        $responses = Utils::settle($promises)->wait();

        foreach ($responses as $response) {
            if ($response['state'] == 'fulfilled') {
                $fulfilledResponses[] = $response['value'];
            }
        }

        return $fulfilledResponses;
    }
}
