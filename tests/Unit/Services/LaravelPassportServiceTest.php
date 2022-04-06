<?php

namespace Tests\Unit\Services;

use App\Http\Services\LaravelPassportService\LaravelPassportServiceInterface;
use App\Models\User;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\TestCase;
use Tests\CreatesApplication;

class LaravelPassportServiceTest extends TestCase
{
    use CreatesApplication;

    /**
     * @var \App\Http\Services\LaravelPassportService\LaravelPassportServiceInterface
     */
    private LaravelPassportServiceInterface $laravelPassportService;

    protected function setUp(): void
    {
        parent::setUp();

        $app = $this->createApplication();

        $this->laravelPassportService = $app->make(LaravelPassportServiceInterface::class);
    }

    /**
     * @return void
     */
    public function test_login_success()
    {
        $email = 'test@test.com';
        $password = 'password';

        $user = $this->createFakeUser($email, $password);

        $tokenData = $this->laravelPassportService->login($email, $password);

        $this->assertArrayHasKey('access_token', $tokenData);
        $this->assertArrayHasKey('refresh_token', $tokenData);
    }

    /**
     * @return void
     */
    public function test_login_failed()
    {
        $email = 'wrong@test.com';
        $password = 'password';

        $this->expectException(GuzzleException::class);

        $this->laravelPassportService->login($email, $password);
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
}
