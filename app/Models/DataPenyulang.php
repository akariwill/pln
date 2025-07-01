<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataPenyulang extends Model
{
    protected $table = 'tabel_data_penyulangs';

    protected $fillable = [
        'id_penyulang', 'tanggal',
        'amp_siang', 'teg_siang', 'mw_siang', 'persen_siang',
        'amp_malam', 'teg_malam', 'mw_malam', 'persen_malam'
    ];

    public function penyulang()
    {
        return $this->belongsTo(Penyulang::class, 'id_penyulang');
    }
}

