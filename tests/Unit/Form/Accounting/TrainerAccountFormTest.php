<?php

namespace Tests\Unit\Form\Accounting;

use App\Form\Accounting\TrainerAccountForm;
use Tests\Unit\BaseTest;

class TrainerAccountFormTest extends BaseTest
{
    /** @dataProvider provider */
    public function test_validate_success(array $data, bool $expected)
    {
        $form = new TrainerAccountForm();
        $form->load($data);
        $this->assertEquals($form->validate(), $expected);
    }

    public function provider(): array
    {
        return [
            [['userId' => 1], true]
        ];
    }
}
