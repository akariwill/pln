<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GarduInduk extends Model
{
    protected $fillable = ['nama', 'kap', 'setting_rele'];

    public function trafoDayas()
    {
        return $this->hasMany(TrafoDaya::class, 'id_gardu_induk');
    }
}

