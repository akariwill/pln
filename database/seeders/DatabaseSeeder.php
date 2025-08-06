<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\GarduInduk;
use App\Models\TrafoDaya;
use App\Models\Penyulang;
use App\Models\DataPenyulang;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // PermissionTableSeeder::class
            RoleSeeder::class
        ]);
    }
}
