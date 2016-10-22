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

    public function getManageLink() {
        return url()->to('/') . "/manage/" . $this->id . '/' . $this->manageToken;
    }

    public function getLeftTeamLink() {
        return url()->to('/') . "/view/" . $this->id . '/' . $this->team1Token;
    }

    public function getRightTeamLink() {
        return url()->to('/') . "/view/" . $this->id . '/' . $this->team2Token;
    }

    public function getSpectatorLink() {
        return url()->to('/') . "/view/" . $this->id;
    }

    public function getTeamFromToken($token) {
        $team = 0;

        if($this->team1Token == $token) {
            $team = 1;
        }

        if($this->team2Token == $token) {
            $team = 2;
        }
        return $team;
    }
}
