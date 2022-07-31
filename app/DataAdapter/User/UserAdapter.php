<?php

namespace App\DataAdapter\User;

use App\DataAdapter\Accounting\AccountAdapter;
use App\Models\User;
use Kiryanov\Adapter\DataAdapter\DataAdapter;
use \Illuminate\Database\Eloquent\Model;
class UserAdapter extends DataAdapter
{
    protected AccountAdapter $accountAdapter;

    public function __construct(AccountAdapter $accountAdapter)
    {
        $this->accountAdapter = $accountAdapter;
    }

    /**
     * @param User $user
     */
    public function getModelData(Model $user) : array
    {
        return [
            'id' => $user->id,
            'firstName' => $user->first_name,
            'lastName' => $user->last_name,
            'middleName' => $user->middle_name,
            'email' => $user->email,
            'phone' => $user->phone,
            'account' => $this->accountAdapter->getModelData($user->account)
        ];
    }
}
