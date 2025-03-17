<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert permissions
        $permissions = [
            ['role_permission_name' => 'manage-all', 'role_permission_description' => 'Memiliki akses penuh untuk mengelola semua aspek pengguna, termasuk pembuatan, pembacaan, pembaruan, dan penghapusan data pengguna.'],
            ['role_permission_name' => 'manage-profile-update', 'role_permission_description' => 'Memiliki izin untuk mengedit profile account nya sendiri.'],
            ['role_permission_name' => 'manage-user-create', 'role_permission_description' => 'Memiliki izin untuk membuat pengguna baru dalam sistem.'],
            ['role_permission_name' => 'manage-user-read', 'role_permission_description' => 'Memiliki izin untuk membaca dan melihat informasi pengguna yang ada dalam sistem.'],
            ['role_permission_name' => 'manage-user-update', 'role_permission_description' => 'Memiliki izin untuk memperbarui informasi pengguna yang ada dalam sistem.'],
            ['role_permission_name' => 'manage-user-delete', 'role_permission_description' => 'Memiliki izin untuk menghapus pengguna dari sistem.'],

            
        ];
        DB::table('role_permissions')->insert($permissions);
    }
}
