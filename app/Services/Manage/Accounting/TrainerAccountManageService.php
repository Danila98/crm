<?php

namespace App\Services\Manage\Accounting;

use App\Form\Accounting\TrainerAccountForm;
use App\Models\Accounting\TrainerAccount;

class TrainerAccountManageService
{
    public function create(
        TrainerAccountForm $form
    ): TrainerAccount
    {
        return TrainerAccount::create([
            'user_id' => $form->getUserId(),
            'max_pupils' => $form->getMaxPupils() ?? TrainerAccount::DEFAULT_MAX_PUPILS,
            'pupils' => $form->getPupils() ?? TrainerAccount::DEFAULT_PUPILS,
        ]);
    }
}
