<?php

namespace Database\Seeders;

use App\Models\Permissions\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{

    public function run(): void
    {
        $manageUser = new Permission();
        $manageUser->name = 'admin';
        $manageUser->slug = 'admin';
        $manageUser->save();
        $createTasks = new Permission();
        $createTasks->name = 'trainer';
        $createTasks->slug = 'trainer';
        $createTasks->save();
    }
}
