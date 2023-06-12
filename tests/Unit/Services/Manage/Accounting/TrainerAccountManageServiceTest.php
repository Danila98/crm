<?php

namespace Tests\Unit\Services\Manage\Accounting;

use App\Form\Accounting\TrainerAccountForm;
use App\Services\Manage\Accounting\TrainerAccountManageService;
use Tests\Unit\BaseTest;

class TrainerAccountManageServiceTest extends BaseTest
{
    public function test_create_success()
    {
        $service = new TrainerAccountManageService();
        $form = new TrainerAccountForm();
        $form->load(['userId' => $this->trainer->id]);

        $account = $service->create($form);

        $this->assertEquals($account->user_id, $this->trainer->id);
        $this->assertEquals($account->pupils, 0); //default
        $this->assertEquals($account->max_pupils, 10);//default
    }
}
