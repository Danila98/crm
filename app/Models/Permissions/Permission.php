<?php

namespace App\Models\Permissions;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_permissions');
    }
}
