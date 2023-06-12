<?php

namespace Tests\Unit\Services\Manage\Area;

use App\Form\Area\AreaForm;
use App\Repository\Accounting\AccountRepository;
use App\Services\Manage\Area\AreaManageService;
use Tests\Unit\BaseTest;

class AreaManageServiceTest extends BaseTest
{
    public function setUp(): void
    {
        parent::setUp();
        $this->createCity();
    }

    public function test()
    {
        $this->actingAs($this->trainer, 'api');
        $validData = [
            'name' => 'name',
            'description' => 'description',
            'city_id' => $this->city->id,
            'street' => 'street',
            'house' => 1,
            'building' => 'building',
        ];
        $form = new AreaForm();
        $form->load($validData);
        $accountRepository = $this->createMock(AccountRepository::class);
        $accountRepository->method('findByUser')->willReturn($this->trainer->account);
        $service = new AreaManageService($accountRepository);
        $area = $service->create($form);
        $this->assertEquals($area->name, $validData['name']);
        $this->assertEquals($area->description, $validData['description']);
        $this->assertEquals($area->city_id, $validData['city_id']);
        $this->assertEquals($area->street, $validData['street']);
        $this->assertEquals($area->house, $validData['house']);
        $this->assertEquals($area->building, $validData['building']);
    }
}
