<?php

namespace Tests\Feature\Base\Authentication\User;

use Tests\Unit\BaseTest;

class LoginTest extends BaseTest
{
    public function test_login_success()
    {
        $validData = ['email' => $this->trainer->email, 'password' => '123'];
        $response = $this->post('/api/v1/auth/login', $validData);

        $response->assertStatus(200);
        $response = json_decode($response->content(), true);
        $this->assertTrue($response['success']);
        $this->assertNotEmpty($response['access_token']);
    }

    public function test_login_fail()
    {
        $invalidData = ['email' => 'emil@mail.ru', 'password' => 125];
        $response = $this->post('/api/v1/auth/login', $invalidData);

        $response->assertStatus(401);
    }
}
