<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MapBan extends Model
{
    public $timestamps = false;

    public function map() {
        return $this->belongsTo(Map::class);
    }

    public function session() {
        return $this->belongsTo(MapBanSession::class);
    }
    //
}
