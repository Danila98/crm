<?php

namespace Tests\Feature\Base\Authentication\User;

use Tests\Unit\BaseTest;

class RegistrationTest extends BaseTest
{
    /** @dataProvider successProvider */
    public function test_registration_success(array $validData)
    {
        $response = $this->post('/api/v1/auth/register', $validData);

        $response->assertStatus(200);
        $response = json_decode($response->content(), true);

        $this->assertTrue($response['success']);
        $this->assertNotEmpty($response['access_token']);
    }

    public function successProvider(): array
    {
        return [
            [
                [
                    'firstName' => 'firstName',
                    'email' => 'email@email.ru',
                    'password' => 123
                ],
            ],
            [
                [
                    'firstName' => 'firstName',
                    'lastName' => 'lastName',
                    'email' => 'email1@email.ru',
                    'password' => 123
                ],
            ],
            [
                [
                    'firstName' => 'firstName',
                    'middleName' => 'middleName',
                    'email' => 'email2@email.ru',
                    'password' => 123
                ],
            ],
            [
                [
                    'firstName' => 'firstName',
                    'phone' => 'phone',
                    'email' => 'email3@email.ru',
                    'password' => 123
                ],
            ],
        ];
    }

    /** @dataProvider failsProvider */
    public function test_registration_fail(array $invalidData)
    {
        $response = $this->post('/api/v1/auth/register', $invalidData);
        $response->assertStatus(417);
    }

    public function failsProvider(): array
    {
        return [
            [
                [
                    'firstName' => 'firstName',
                    'email' => 'email',
                    'password' => 123
                ],
            ],
            [
                [
                    'email' => 'email@email.ru',
                    'password' => 123
                ],
            ],
            [
                [
                    'firstName' => 'firstName',
                    'email' => 'email@email.ru',
                ],
            ],
        ];
    }
}
