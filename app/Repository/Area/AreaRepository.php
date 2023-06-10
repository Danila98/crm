<?php

namespace App\Repository\Area;

use App\Models\Accounting\TrainerAccount;
use App\Models\Area\Area;
use Spatie\FlareClient\Http\Exceptions\NotFound;

class AreaRepository
{
    public function save(Area $area): void
    {
        $area->save();
    }

    public function findByUser($user)
    {
        $account = TrainerAccount::where(['user_id' => $user->id])->first();

        return $account->area;
    }

    public function find(int $id)
    {
        if ($area = Area::find($id)) {
            return $area;
        } else {
            throw new NotFound();
        }
    }
}
