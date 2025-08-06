<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Jalankan seeder.
     */
    public function run(): void
    {
        // Buat role admin
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Ambil semua permission yang ada
        $permissions = Permission::all();

        // Assign semua permission ke role admin
        $adminRole->syncPermissions($permissions);
    }
}
