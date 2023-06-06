<?php

namespace Tests\Unit\Services\Manage\Accounting;

use App\Form\Accounting\TrainerAccountForm;
use App\Models\User;
use App\Services\Manage\Accounting\TrainerAccountManageService;
use Tests\Unit\BaseUnitTest;

class TrainerAccountManageServiceTest extends BaseUnitTest
{
    public function test_create_success()
    {
        User::create([
            'firstName' => 'noFirstName',
            'password' => 'noPassword',
            'email' => 'noEmail@email.ru',
        ]);
        $service = new TrainerAccountManageService();
        $form = new TrainerAccountForm();
        $form->load(['userId' => 1]);

        $account = $service->create($form);

        $this->assertEquals($account->user_id, 1);
        $this->assertEquals($account->pupils, 0); //default
        $this->assertEquals($account->max_pupils, 10);//default
    }
}
