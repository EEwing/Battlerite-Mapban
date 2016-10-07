<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MapBanSession extends Model
{

    public function owner() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bans() {
        return $this->belongsToMany(Map::class, 'map_bans');
    }

    public function chosenMap() {
        return $this->belongsTo(Map::class, 'chosen_map');
    }
}
