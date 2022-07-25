<?php

namespace App\Repository\Area;

use App\Models\Accounting\TrainerAccount;
use App\Models\Area\GroupCategory;

class GroupCategoryRepository
{

    public function find(int $id)
    {
        return GroupCategory::find($id);
    }

    public function findByAccount(TrainerAccount $account)
    {
        return GroupCategory::where(['account_id' => $account->id])->get();
    }

}
