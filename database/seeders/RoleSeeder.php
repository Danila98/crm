<?php

namespace Database\Seeders;

use App\Models\Permissions\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $manager = new Role();
        $manager->name = 'admin';
        $manager->slug = 'admin';
        $manager->save();
        $developer = new Role();
        $developer->name = 'trainer';
        $developer->slug = 'trainer';
        $developer->save();
    }
}
