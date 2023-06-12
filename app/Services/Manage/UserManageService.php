<?php

namespace App\Services\Manage;

use App\Form\User\UserForm;
use App\Models\User;
use App\Repository\Accounting\UserRepository;
use App\Repository\Permission\RoleRepository;

class UserManageService
{
    protected UserRepository $userRepository;
    protected RoleRepository $roleRepository;

    public function __construct(
        UserRepository $userRepository,
        RoleRepository $roleRepository,
    )
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    public function create(UserForm $form): User
    {

        $user = User::create([
            'first_name' => $form->getFirstName(),
            'last_name' => $form->getLastName(),
            'middle_name' => $form->getMiddleName(),
            'email' => $form->getEmail(),
            'phone' => $form->getPhone(),
            'password' => bcrypt($form->getPassword()
            ),
        ]);
        $trainerRole = $this->roleRepository->getBySlug(User::ROLE_TRAINER);
        $user->roles()->attach($trainerRole);

        return $user;
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
