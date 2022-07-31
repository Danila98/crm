<?php

namespace App\DataAdapter\Accounting;

use App\Models\Accounting\Account;
use Illuminate\Database\Eloquent\Model;
use Kiryanov\Adapter\DataAdapter\DataAdapter;

class AccountAdapter extends DataAdapter
{
    /**
     * @param Account $account
     */
    public function getModelData(Model $account) : array
    {
        return [
            'pupils' => $account->pupils,
            'maxPupils' => $account->max_pupils,
        ];
    }
}
