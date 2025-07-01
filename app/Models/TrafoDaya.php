<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrafoDaya extends Model
{
    protected $fillable = ['id_gardu_induk', 'nama', 'kap', 'setting_rele'];

    public function garduInduk()
    {
        return $this->belongsTo(GarduInduk::class, 'id_gardu_induk');
    }

    public function penyulangs()
    {
        return $this->hasMany(Penyulang::class, 'id_trafo_daya');
    }
}


