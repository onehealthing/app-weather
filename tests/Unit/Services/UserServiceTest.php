<?php

namespace Tests\Unit\Services;

use App\Http\Services\UserService\UserServiceInterface;
use App\Models\User;
use PHPUnit\Framework\TestCase;
use Tests\CreatesApplication;

class UserServiceTest extends TestCase
{
    use CreatesApplication;

    /**
     * @var \App\Http\Services\UserService\UserServiceInterface
     */
    private UserServiceInterface $userService;

    protected function setUp(): void
    {
        parent::setUp();

        $app = $this->createApplication();
        $this->userService = $app->make(UserServiceInterface::class);
    }

    /**
     * @return void
     */
    public function test_register_user_success()
    {
        $name = 'name';
        $email = 'email@test.com';
        $password = 'password';

        if ($user = User::where('email', $email)->first()) {
            $this->assertEquals($name, $user->name);
            $this->assertEquals($email, $user->email);

            return;
        }

        $registeredUser = $this->userService->register($name, $email, $password);

        $this->assertEquals($name, $registeredUser->name);
        $this->assertEquals($email, $registeredUser->email);
    }
}
