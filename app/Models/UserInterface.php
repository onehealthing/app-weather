<?php

namespace App\Models;

interface UserInterface
{
    /**
     * @param string $name
     * @param string $email
     * @param string $password
     *
     * @return \App\Models\User
     */
    public function store(string $name, string $email, string $password): User;
}
