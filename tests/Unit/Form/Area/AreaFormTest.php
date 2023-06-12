<?php

namespace Tests\Unit\Form\Area;

use App\Form\Area\AreaForm;
use Tests\Unit\BaseTest;

class AreaFormTest extends BaseTest
{
    public function test_validation_success()
    {
        $validData = [
            'name' => 'name',
            'description' => 'description',
            'city_id' => 1,
            'street' => 'street',
            'house' => 1,
            'building' => 'building',
        ];
        $form = new AreaForm();
        $form->load($validData);

        $this->assertTrue($form->validate());
    }

    /**
     * @dataProvider failProvider
     */
    public function test_validation_fail(array $invalidData)
    {
        $form = new AreaForm();
        $form->load($invalidData);

        $this->assertFalse($form->validate());
    }

    private function failProvider(): array
    {
        return [
            [[
                'description' => 'description',
                'city_id' => 1,
                'street' => 'street',
                'house' => 1,
            ]],
            [[
                'name' => 'name',
                'description' => 'description',
                'street' => 'street',
                'house' => 1,
            ]],
            [[
                'name' => 'name',
                'description' => 'description',
                'city_id' => 1,
                'house' => 1,
            ]],
            [[
                'name' => 'name',
                'description' => 'description',
                'city_id' => 1,
                'street' => 'street',
            ]],
        ];
    }
}
