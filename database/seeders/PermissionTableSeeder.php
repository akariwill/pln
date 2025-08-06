<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Gardu Induk
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',

            'gardu-induk-list',
            'gardu-induk-create',
            'gardu-induk-edit',
            'gardu-induk-delete',

            // Trafo Daya
            'trafo-daya-list',
            'trafo-daya-create',
            'trafo-daya-edit',
            'trafo-daya-delete',

            // Penyulang
            'penyulang-list',
            'penyulang-create',
            'penyulang-edit',
            'penyulang-delete',

            // Data Penyulang
            'data-penyulang-list',
            'data-penyulang-create',
            'data-penyulang-edit',
            'data-penyulang-delete',

            // Profile
            'profile-edit',
            'profile-update',
            'profile-destroy',

            // Prediksi
            'prediksi-index',
            'prediksi-submit',

            // Cek Data Penyulang
            'cek-data-penyulang',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
