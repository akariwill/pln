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
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $kapasitor = 30;

        for ($g = 1; $g <= 2; $g++) {
            $gardu = GarduInduk::create([
                'nama' => "Gardu Induk $g",
            ]);

            for ($t = 1; $t <= 2; $t++) {
                $trafo = TrafoDaya::create([
                    'id_gardu_induk' => $gardu->id,
                    'nama' => "Trafo $t - GI $g",
                    'kap' => 100,
                    'setting_rele' => 20 + $t
                ]);

                for ($p = 1; $p <= 2; $p++) {
                    $penyulang = Penyulang::create([
                        'id_trafo_daya' => $trafo->id,
                        'nama' => "Penyulang $p - Trafo $t - GI $g",
                        'setting_rele' => 25 + $p,
                    ]);

                    for ($i = 0; $i < 30; $i++) {
                        $date = Carbon::now()->subDays(30 - $i);
                        $mwSiang = rand(800, 1200) / 100;
                        $mwMalam = rand(700, 1100) / 100;

                        DataPenyulang::create([
                            'id_penyulang' => $penyulang->id,
                            'bulan' => $date->month,
                            'tahun' => $date->year,
                            'amp_siang' => rand(90, 110),
                            'teg_siang' => rand(19800, 20200),
                            'mw_siang' => $mwSiang,
                            'persen_siang' => round($mwSiang / ($kapasitor * 0.9) * 100, 2),
                            'amp_malam' => rand(85, 105),
                            'teg_malam' => rand(19800, 20200),
                            'mw_malam' => $mwMalam,
                            'persen_malam' => round($mwMalam / ($kapasitor * 0.9) * 100, 2),
                            'created_at' => $date,
                            'updated_at' => $date,
                        ]);
                    }
                }
            }
        }
    }
}
