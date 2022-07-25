<?php

namespace App\Repository\Area;

use App\Models\Accounting\TrainerAccount;
use App\Models\Area\Area;
use App\Models\Area\Group;
use Intervention\Image\Exception\NotFoundException;

class GroupRepository
{

    public function find(int $id)
    {
        $group = Group::find($id);
        if ($group)
        {
            return $group;
        }else
        {
            throw new NotFoundException();
        }
    }

    public function findByAccount(TrainerAccount $account )
    {
        return Group::where(['account_id' => $account->id])->get();
    }

    public function findByArea(Area $area)
    {
        return Group::where(['area_id' => $area->id])->get();
    }

    public function findByAreaAndAccount(Area $area, TrainerAccount $account)
    {
        return Group::where(['area_id' => $area->id, 'account_id' => $account->id])->get();
    }

}
