<?php

namespace Tests\Unit\Services\Manage;

use App\Form\User\UserForm;
use App\Models\User;
use App\Repository\Accounting\UserRepository;
use App\Services\Manage\UserManageService;
use Tests\Unit\BaseUnitTest;

class UserManageServiceTest extends BaseUnitTest
{
    public function test_create_all_fields_success()
    {
        $formData = [
            'firstName' => 'firstName',
            'lastName' => 'lastName',
            'middleName' => 'middleName',
            'phone' => 'phone',
            'password' => 'password',
            'email' => 'email@email.ru',
        ];
        $userRepository = $this->createMock(UserRepository::class);
        $form = new UserForm();
        $form->load($formData);
        $service = new UserManageService($userRepository);
        $user = $service->create($form);

        $this->assertEquals($user->first_name, $formData['firstName']);
        $this->assertEquals($user->last_name, $formData['lastName']);
        $this->assertEquals($user->middle_name, $formData['middleName']);
        $this->assertEquals($user->phone, $formData['phone']);
        $this->assertNotEmpty($user->password);
        $this->assertEquals($user->email, $formData['email']);
        $this->assertNotEmpty($user->id);
    }

    public function test_create_all_min_success()
    {
        $formData = [
            'firstName' => 'firstName',
            'password' => 'password',
            'email' => 'email@email.ru',
        ];
        $userRepository = $this->createMock(UserRepository::class);
        $form = new UserForm();
        $form->load($formData);
        $service = new UserManageService($userRepository);
        $user = $service->create($form);

        $this->assertEquals($user->first_name, $formData['firstName']);
        $this->assertNotEmpty($user->password);
        $this->assertEquals($user->email, $formData['email']);
        $this->assertNotEmpty($user->id);
    }

    public function test_update_success()
    {
        $userId = 1;
        $formData = [
            'firstName' => 'firstName',
            'lastName' => 'lastName',
            'middleName' => 'middleName',
            'phone' => 'phone',
            'password' => 'password',
            'email' => 'email@email.ru',
        ];
        $userRepository = $this->createMock(UserRepository::class);
        $userRepository->method('get')->willReturn(User::create([
            'firstName' => 'noFirstName',
            'password' => 'noPassword',
            'email' => 'noEmail@email.ru',
        ]));
        $userRepository->expects($this->once())
            ->method('save');
        $form = new UserForm();
        $form->load($formData);
        $service = new UserManageService($userRepository);
        $user = $service->update($form, $userId);

        $this->assertEquals($user->first_name, $formData['firstName']);
        $this->assertEquals($user->last_name, $formData['lastName']);
        $this->assertEquals($user->middle_name, $formData['middleName']);
        $this->assertEquals($user->phone, $formData['phone']);
        $this->assertNotEmpty($user->password);
        $this->assertEquals($user->email, $formData['email']);
    }
}
