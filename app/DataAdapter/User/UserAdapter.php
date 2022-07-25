<?php

namespace App\DataAdapter\User;

use App\Models\User;
use Kiryanov\Adapter\DataAdapter\DataAdapter;
use \Illuminate\Database\Eloquent\Model;
class UserAdapter extends DataAdapter
{
    /**
     * @param User $user
     */
    public function getModelData(Model $user) : array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email
        ];
    }
}
