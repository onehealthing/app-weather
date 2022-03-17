<?php

namespace App\Http\Services\LaravelPassportService;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class LaravelPassportService implements LaravelPassportServiceInterface
{
    protected const DOMAIN = 'http://webserver/';

    /**
     * @param \GuzzleHttp\Client $client
     */
    public function __construct(
        private Client $client
    ) {}

    /**
     * @param string $email
     * @param string $password
     *
     * @return array
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function login(string $email, string $password): array
    {
        $response = $this->client->request('POST', static::DOMAIN . 'oauth/token', [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => config('passport.personal_access_client.id'),
                'client_secret' => config('passport.personal_access_client.secret'),
                'username' => $email,
                'password' => $password,
                'scope' => '',
            ]
        ]);

        return $this->getTokenDataFromResponse($response);
    }

    /**
     * @param \GuzzleHttp\Psr7\Response $response
     *
     * @return array
     */
    protected function getTokenDataFromResponse(Response $response): array
    {
        $tokenData = json_decode($response->getBody(), true);

        return [
            'access_token' => $tokenData['access_token'],
            'refresh_token' => $tokenData['refresh_token'],
        ];
    }

}
