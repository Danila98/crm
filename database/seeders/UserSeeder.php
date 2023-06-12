<?php

namespace Database\Seeders;

use App\Models\Accounting\TrainerAccount;
use App\Models\Permissions\Permission;
use App\Models\Permissions\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

    public function run(): void
    {
        $adminRole = Role::where('slug', 'admin')->first();
        $trainerRole = Role::where('slug', 'trainer')->first();
        $adminPermission = Permission::where('slug', 'admin')->first();
        $trainerPermission = Permission::where('slug', 'trainer')->first();
        $user1 = new User();
        $user1->first_name = 'testAdmin';
        $user1->email = 'admin@test.ru';
        $user1->password = bcrypt('123');
        $user1->save();
        $account1 = TrainerAccount::create(['user_id' => $user1->id]);
        $user1->roles()->attach($adminRole);
        $user1->permissions()->attach($adminPermission);
        $user2 = new User();
        $user2->first_name = 'testTrainer';
        $user2->email = 'trainer@test.ru';
        $user2->password = bcrypt('123');
        $user2->save();
        $account2 = TrainerAccount::create(['user_id' => $user2->id]);

        $user2->roles()->attach($trainerRole);
        $user2->permissions()->attach($trainerPermission);
    }
}
