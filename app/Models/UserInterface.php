<?php

namespace App\Models;

interface UserInterface
{
    /**
     * @param string $name
     * @param string $email
     * @param string $password
     *
     * @return void
     */
    public function store(string $name, string $email, string $password): void;
}
