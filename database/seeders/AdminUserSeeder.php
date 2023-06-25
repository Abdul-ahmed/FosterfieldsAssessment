<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Laratrust\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mega = User::create([
            'first_name' => 'Mega',
            'last_name' => 'Admin',
            'email' => 'mega.admin@assessment.com',
            'password' => 'mega.admin.password'
        ]);

        $super = User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'super.admin@assessment.com',
            'password' => 'super.admin.password'
        ]);

        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin.admin@assessment.com',
            'password' => 'admin.admin.password'
        ]);

        $mega->addRoles([Role::find(1), Role::find(2)]);
        $super->addRole(Role::find(1));
        $admin->addRole(Role::find(2));

    }
}
