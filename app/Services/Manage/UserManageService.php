<?php

namespace App\Services\Manage;

use App\Form\User\UserForm;
use App\Models\User;
use App\Repository\Accounting\UserRepository;

class UserManageService
{
    protected UserRepository $userRepository;

    public function __construct(
        UserRepository $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    public function create(UserForm $form)
    {
        return User::create([
            'first_name' => $form->getFirstName(),
            'last_name' => $form->getLastName(),
            'middle_name' => $form->getMiddleName(),
            'email' => $form->getEmail(),
            'phone' => $form->getPhone(),
            'password' => bcrypt($form->getPassword()
            ),
        ]);
    }

    public function update(UserForm $form, int $userId)
    {
        $user = $this->userRepository->get($userId);
        $user->first_name = $form->getFirstName();
        $user->last_name = $form->getLastName();
        $user->middle_name = $form->getMiddleName();
        $user->email = $form->getEmail();
        $user->phone = $form->getPhone();

        $this->userRepository->save($user);

        return $user;
    }
}
