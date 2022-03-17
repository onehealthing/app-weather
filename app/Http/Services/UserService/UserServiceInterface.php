<?php

namespace App\Http\Services\UserService;

interface UserServiceInterface
{
    /**
     * @param string $name
     * @param string $email
     * @param string $password
     *
     * @return void
     */
    public function register(string $name, string $email, string $password): void;
}
