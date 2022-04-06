<?php

namespace App\Http\Services\UserService;

use App\Models\User;
use App\Models\UserInterface;

class UserService implements UserServiceInterface
{
    public function __construct(
        private UserInterface $user
    ) {}

    /**
     * @param string $name
     * @param string $email
     * @param string $password
     *
     * @return \App\Models\User
     */
    public function register(string $name, string $email, string $password): User
    {
        return $this->user->store($name, $email, $password);
    }
}
