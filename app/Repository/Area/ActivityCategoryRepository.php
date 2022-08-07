<?php

namespace App\Repository\Area;

use App\Models\Area\ActivityCategory;
use App\Repository\AbstractRepository;

class ActivityCategoryRepository extends AbstractRepository
{

    public function findByUser($user)
    {
        return ActivityCategory::where(['account_id' => $user->account_id])->get();
    }

    protected function getClass(): string
    {
        return ActivityCategory::class;
    }
}
