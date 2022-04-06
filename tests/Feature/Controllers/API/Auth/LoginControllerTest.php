<?php

namespace Tests\Feature\Controllers\API\Auth;

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Model;
use Tests\CreatesApplication;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use CreatesApplication;

    /**
     * @return void
     */
    public function test_user_login_success()
    {
        $email = 'email@test.com';
        $password = 'password';

        $user = $this->createFakeUser($email, $password);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $responseContent = json_decode($response->getContent(), true);

        $response->assertStatus(200);
        $this->assertArrayHasKey('access_token', $responseContent);
        $this->assertArrayHasKey('refresh_token', $responseContent);
    }

    /**
     * @return void
     */
    public function test_user_register_failed()
    {
        $userCredentials = $this->getFakeUserCredentials();

        $response = $this->postJson('/api/login', $userCredentials);

        $response->assertStatus(500);
        $response->assertJson([
            'message' => 'Can`t login user',
        ]);
    }

    /**
     * @param string $email
     * @param string $password
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    private function createFakeUser(string $email, string $password): Model
    {
        if ($user = User::where('email', $email)->first()) {
            return $user;
        }

        return User::factory()->create([
            'email' => $email,
            'password' => bcrypt($password),
        ]);
    }

    /**
     * @return array
     */
    private function getFakeUserCredentials(): array
    {
        $app = $this->createApplication();
        $faker = $app->make(Faker::class);

        return [
            'email' => $faker->email,
            'password' => $faker->password(),
        ];
    }
}
