<?php

namespace App\Repository\Accounting;

use App\Models\User;
use App\Repository\AbstractRepository;

class UserRepository extends AbstractRepository
{
    public function save(User $user)
    {
        $user->save();
    }

    protected function getClass(): string
    {
        return User::class;
    }
}
