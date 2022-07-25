<?php

namespace App\Repository\Area;

use App\Models\Accounting\TrainerAccount;
use App\Models\Area\Area;
use Intervention\Image\Exception\NotFoundException;

class AreaRepository
{

    public function findByUser($user)
    {
        $account = TrainerAccount::where(['user_id' => $user->id])->first();

        return $account->area;
    }

    public function find(int $id)
    {
        $area = Area::find($id);
        if ($area)
        {
            return $area;
        }else
        {
            throw new NotFoundException();
        }
    }
}
