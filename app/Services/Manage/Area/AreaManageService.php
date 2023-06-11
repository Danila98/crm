<?php

namespace App\Services\Manage\Area;

use App\Form\Area\AreaForm;
use App\Jobs\Area\AreaPodcast;
use App\Models\Area\Area;
use App\Repository\Accounting\AccountRepository;

class AreaManageService
{
    private AccountRepository $accountRepository;

    public function __construct(
        AccountRepository $accountRepository
    )
    {
        $this->accountRepository = $accountRepository;
    }

    public function create(AreaForm $form): Area
    {
        $area = Area::create([
            'name' => $form->getName(),
            'description' => $form->getDescription(),
            'building' => $form->getBuilding(),
            'street' => $form->getStreet(),
            'house' => $form->getHouse(),
            'city_id' => $form->getCityId(),
        ]);
        $account = $this->accountRepository->findByUser(auth('api')->user());
        $account->area()->attach($area->id);
        AreaPodcast::dispatch($area);

        return $area;
    }
}
