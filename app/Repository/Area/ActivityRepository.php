<?php

namespace App\Repository\Area;

use App\Models\Area\Activity;
use App\Repository\AbstractRepository;

class ActivityRepository extends AbstractRepository
{
    public function findByUser($user)
    {
        return Activity::where(['account_id' => $user->account_id])->get();
    }

    protected function getClass(): string
    {
       return Activity::class;
    }
}
