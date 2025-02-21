<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['role_name' => 'super-admin', 'role_description' => 'Full access to all resources', 'created_at' => now(), 'updated_at' => now()],
            ['role_name' => 'admin', 'role_description' => 'Manage resources and users', 'created_at' => now(), 'updated_at' => now()],
            ['role_name' => 'user', 'role_description' => 'General user access', 'created_at' => now(), 'updated_at' => now()],
        ];
        DB::table('roles')->insert($roles);
    }
}
