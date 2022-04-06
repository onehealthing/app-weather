<?php

namespace App\Http\Services\UserService;

use App\Models\User;

interface UserServiceInterface
{
    /**
     * @param string $name
     * @param string $email
     * @param string $password
     *
     * @return \App\Models\User
     */
    public function register(string $name, string $email, string $password): User;
}
