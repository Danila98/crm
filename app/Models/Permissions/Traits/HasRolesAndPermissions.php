<?php

namespace App\Models\Permissions\Traits;

use App\Models\Permissions\Permission;
use App\Models\Permissions\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

//https://laravel.demiart.ru/guide-to-roles-and-permissions/
trait HasRolesAndPermissions
{
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'users_roles');
    }

    public function hasRole(...$roles): bool
    {
        foreach ($roles as $role) {
            if ($this->roles->contains('slug', $role)) {
                return true;
            }
        }
        return false;
    }

    public function hasPermissionTo($permission)
    {
        return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission->slug);
    }

    public function hasPermissionThroughRole($permission): bool
    {
        foreach ($permission->roles as $role) {
            if ($this->roles->contains($role)) {
                return true;
            }
        }
        return false;
    }

    public function hasPermission($permission): bool
    {
        return (bool)$this->permissions->where('slug', $permission)->count();
    }

    public function deletePermissions(...$permissions): static
    {
        $permissions = $this->getAllPermissions($permissions);
        $this->permissions()->detach($permissions);
        return $this;
    }

    public function getAllPermissions(array $permissions)
    {
        return Permission::whereIn('slug', $permissions)->get();
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'users_permissions');
    }

    public function refreshPermissions(...$permissions): User
    {
        $this->permissions()->detach();
        return $this->givePermissionsTo($permissions);
    }

    public function givePermissionsTo(...$permissions): static
    {
        $permissions = $this->getAllPermissions($permissions);
        if ($permissions === null) {
            return $this;
        }
        $this->permissions()->saveMany($permissions);
        return $this;
    }
}
