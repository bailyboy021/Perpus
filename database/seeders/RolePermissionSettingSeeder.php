<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert permissions
        $permissionSettings = [
            ['role_id' => '1', 'role_permission_id' => 1 ],
            ['role_id' => '2', 'role_permission_id' => 2 ],
            ['role_id' => '2', 'role_permission_id' => 3 ],
            ['role_id' => '2', 'role_permission_id' => 4 ],
            ['role_id' => '2', 'role_permission_id' => 5 ],
            ['role_id' => '2', 'role_permission_id' => 6 ],
            ['role_id' => '3', 'role_permission_id' => 2 ],
            
        ];
        DB::table('role_permission_settings')->insert($permissionSettings);
    }
}
