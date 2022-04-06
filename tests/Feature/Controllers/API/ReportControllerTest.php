<?php

namespace Tests\Feature\Controllers\API;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Tests\CreatesApplication;
use Tests\TestCase;

class ReportControllerTest extends TestCase
{
    use CreatesApplication;

    /**
     * @return void
     */
    public function test_report_correct()
    {
        $email = 'email@test.com';
        $password = 'password';
        $airports = 'UKBB';
        $format = 'json';

        $user = $this->createFakeUser($email, $password);

        $tokenData = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $accessToken = $tokenData['access_token'];

        $response = $this->withHeader("Authorization" , "Bearer $accessToken")
            ->get("/api/report?airports=$airports&format=$format");

        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function test_report_incorrect_format()
    {
        $email = 'email@test.com';
        $password = 'password';
        $airports = 'UKBB';
        $format = 'xml';

        $user = $this->createFakeUser($email, $password);

        $tokenData = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $accessToken = $tokenData['access_token'];

        $response = $this->withHeader("Authorization" , "Bearer $accessToken")
            ->get("/api/report?airports=$airports&format=$format");

        $response->assertStatus(200);
        $response->assertJson([
            'message' => "Format '$format' not available",
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
}
