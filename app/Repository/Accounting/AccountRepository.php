<?php

namespace App\Repository\Accounting;

use App\Models\Accounting\TrainerAccount;

class AccountRepository
{
    public function findByUser($user)
    {
        return TrainerAccount::where(['user_id' => $user->id])->first();
    }
}
