<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penyulang extends Model
{
    protected $fillable = ['id_trafo_daya', 'nama', 'setting_rele'];

    public function trafoDaya()
    {
        return $this->belongsTo(TrafoDaya::class, 'id_trafo_daya');
    }

    public function dataPenyulangs()
    {
        return $this->hasMany(DataPenyulang::class, 'id_penyulang');
    }

    public function gardu_induk()
    {
        return $this->belongsTo(GarduInduk::class);
    }

    public function trafo_daya()
    {
        return $this->belongsTo(TrafoDaya::class);
    }

}
