<?php

namespace App\Http\Services\LaravelPassportService;

interface LaravelPassportServiceInterface
{
    /**
     * @param string $email
     * @param string $password
     *
     * @return array
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function login(string $email, string $password): array;
}
