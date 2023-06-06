<?php

namespace Tests\Unit\Form\User;

use App\Form\User\UserForm;
use Tests\Unit\BaseUnitTest;

class UserFormTest extends BaseUnitTest
{
    /** @dataProvider provider */
    public function test_validate_form(array $data, bool $expected)
    {
        $form = new UserForm();
        $form->load($data);

        $this->assertEquals($form->validate(), $expected);
    }

    public function provider(): array
    {
        return [
            [[
                'firstName' => 'firstName',
                'lastName' => 'lastName',
                'middleName' => 'middleName',
                'phone' => 'phone',
                'password' => 'password',
                'email' => 'email@email.ru',
            ], true],
            [[
                'lastName' => 'lastName',
                'middleName' => 'middleName',
                'phone' => 'phone',
                'password' => 'password',
                'email' => 'email@email.ru',
            ], false],
            [[
                'firstName' => 'firstName',
                'middleName' => 'middleName',
                'phone' => 'phone',
                'password' => 'password',
                'email' => 'email@email.ru',
            ], true],
            [[
                'firstName' => 'firstName',
                'lastName' => 'lastName',
                'phone' => 'phone',
                'password' => 'password',
                'email' => 'email@email.ru',
            ], true],
            [[
                'firstName' => 'firstName',
                'lastName' => 'lastName',
                'middleName' => 'middleName',
                'password' => 'password',
                'email' => 'email@email.ru',
            ], true],
            [[
                'firstName' => 'firstName',
                'lastName' => 'lastName',
                'middleName' => 'middleName',
                'phone' => 'phone',
                'email' => 'email@email.ru',
            ], true],
            [[
                'firstName' => 'firstName',
                'lastName' => 'lastName',
                'middleName' => 'middleName',
                'phone' => 'phone',
                'password' => 'password',
            ], false],
            [[
                'firstName' => 'firstName',
                'lastName' => 'lastName',
                'middleName' => 'middleName',
                'phone' => 'phone',
                'password' => 'password',
                'email' => 'email',
            ], false],
        ];
    }
}
