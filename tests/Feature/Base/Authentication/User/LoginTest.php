<?php

namespace Tests\Feature\Base\Authentication\User;

use App\Models\User;
use Tests\Unit\BaseTest;

class LoginTest extends BaseTest
{
    public function test_login_success()
    {
        $this->createUser();
        $validData = ['email' => 'email@mail.ru', 'password' => 123];
        $response = $this->post('/api/v1/auth/login', $validData);

        $response->assertStatus(200);
        $response = json_decode($response->content(), true);
        $this->assertTrue($response['success']);
        $this->assertNotEmpty($response['access_token']);
    }

    private function createUser(): void
    {
        User::create(['firstName' => 'firstName', 'email' => 'email@mail.ru', 'password' => bcrypt(123)]);
    }

    public function test_login_fail()
    {
        $this->createUser();
        $invalidData = ['email' => 'emil@mail.ru', 'password' => 125];
        $response = $this->post('/api/v1/auth/login', $invalidData);

        $response->assertStatus(401);
    }
}
