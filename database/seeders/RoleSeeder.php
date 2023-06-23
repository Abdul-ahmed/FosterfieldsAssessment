<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Laratrust\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'super_admin',
                'display_name' => 'Super Admin',
            ],
            [
                'name' => 'admin',
                'display_name' => 'Admin',
            ],
            [
                'name' => 'user',
                'display_name' => 'User',
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
