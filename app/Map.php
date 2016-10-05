<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
    public function bans() {
        return $this->belongsToMany(MapBanSession::class, 'map_bans');
    }
}
