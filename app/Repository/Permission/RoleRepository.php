<?php

namespace App\Repository\Permission;

use App\Models\Permissions\Role;
use App\Repository\AbstractRepository;
use Spatie\FlareClient\Http\Exceptions\NotFound;

class RoleRepository extends AbstractRepository
{
    public function get(int $id)
    {
        $model = Role::find($id);
        if ($model) {
            return $model;
        } else {
            throw new NotFound();
        }
    }

    public function getBySlug(string $slug): Role
    {
        return Role::where('slug', $slug)->firstOrFail();
    }

    protected function getClass(): string
    {
        return Role::class;
    }
}
