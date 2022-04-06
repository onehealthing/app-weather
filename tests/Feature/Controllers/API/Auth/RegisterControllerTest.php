<?php

namespace Tests\Feature\Controllers\API\Auth;

use Faker\Generator as Faker;
use Tests\CreatesApplication;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use CreatesApplication;

    /**
     * @return void
     */
    public function test_user_register_success()
    {
        $response = $this->postJson('/api/register', $this->getFakeUserCredentials());

        $response->assertStatus(201);
        $response->assertJson([
            'message' => 'User registered.'
        ]);
    }

    /**
     * @return void
     */
    public function test_user_register_failed()
    {
        $userCredentials = [
            'name' => 't',
            'email' => 'tt',
            'password' => '',
            'password_confirmation' => '',
        ];

        $response = $this->postJson('/api/register', $userCredentials);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'The given data was invalid.',
        ]);
        $response->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    /**
     * @return array
     */
    private function getFakeUserCredentials(): array
    {
        $app = $this->createApplication();
        $faker = $app->make(Faker::class);
        $password = $faker->password();

        return [
            'name' => $faker->name,
            'email' => $faker->email,
            'password' => $password,
            'password_confirmation' => $password,
        ];
    }
}
