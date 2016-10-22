<?php

namespace App\Http\Controllers;

use App\Events\MapBanned;
use App\Events\TeamReady;
use App\Map;
use App\MapBan;
use App\MapBanSession;
use Illuminate\Http\Request;

use App\Http\Requests;

class MapBanController extends Controller
{

    public function create() {
        return view('createSession');
    }

    public function manage(MapBanSession $mapban, $token) {
        if($mapban->manageToken != $token) {
            return "Unauthorized";
        }
        return view('manage', compact('mapban'));
    }

    public function store(Request $request) {
        $this->validate($request, [
            'team1Name' => 'required|max:25',
            'team2Name' => 'required|max:25'
        ]);

        $mb_session = new MapBanSession;
        $mb_session->manageToken = str_random(15);
        $mb_session->team1Name = $request->team1Name;
        $mb_session->team1Token = str_random(15);
        $mb_session->team2Name = $request->team2Name;
        $mb_session->team2Token = str_random(15);
        $mb_session->save();

        return redirect('/manage/' . $mb_session->id . '/' . $mb_session->manageToken);
    }

    public function spectate(MapBanSession $mapban) {
        return $this->viewTeam($mapban, '0');
    }

    public function viewTeam(MapBanSession $mapban, $token) {

        if($mapban->finished) {
            return $this->viewResults();
        }

        $team = 0;

        if($mapban->team1Token == $token) {
            $team = 1;
        }

        if($mapban->team2Token == $token) {
            $team = 2;
        }

        $maps = Map::all();

        return view('mapban', compact('mapban', 'team', 'maps'));

    }

    public function readyTeam(MapBanSession $mapban, $token) {
        $team = 0;
        if($mapban->team1Token == $token) {
            $team = 1;
            $mapban->team1Ready = true;
        } else if($mapban->team2Token == $token) {
            $team = 2;
            $mapban->team2Ready = true;
        } else {
            return "Must be on a valid team to get ready";
        }

        if($mapban->team1Ready && $mapban->team2Ready) {
            $mapban->stage = 1;
        }

        $mapban->save();
        event(new TeamReady($team, $mapban));
        return "success";
    }

    public function banMap(Request $request, MapBanSession $mapban, $token) {
        $team = $mapban->getTeamFromToken($token);

        $this->validate($request, [
            'map_id' => 'required',
        ]);

        if($team == 0) {
            return "Spectators can't ban maps";
        }

        if(!($mapban->team1Ready && $mapban->team2Ready)) {
            return "Banning can only start once both teams are ready!";
        }

        if($mapban->finished) {
            return "Map banning phase has finished!";
        }

        if($team != $mapban->current_team) {
            return "It is not your team's turn to ban!";
        }
        $bannedMaps = $mapban->bans;
        foreach($bannedMaps as $map) {
            if($map->id == $request->map_id) {
                return "That map is already banned";
            }
        }

        $ban = new MapBan();
        $ban->map_id = $request->map_id;
        $ban->map_ban_session_id = $mapban->id;
        $ban->banned_by = $team;
        $ban->save();

        $mapban = $mapban->fresh();
        $bannedMaps = $mapban->bans;
        $mapCount = Map::all()->count();
        $bansCount = $mapban->bans()->count();

        if($bansCount >= $mapCount-1) {
            $mapban->finished = 1;
            foreach(Map::all() as $map) {
                if(!$bannedMaps->contains($map)) {
                    $mapban->chosen_map = $map->id;
                    break;
                }
            }
        }

        if($team == 1) {
            $mapban->current_team = 2;
        } else {
            $mapban->current_team = 1;
        }

        $mapban->save();

        $map = Map::where('id', '=', $ban->map_id)->first();

        event(new MapBanned($map, $mapban));

        return "success";
    }

    public function viewResults(MapBanSession $mapban) {
        if(!$mapban->finished) {
            return redirect('/view/'.$mapban->id);
        }

        $maps = Map::all();
        return view('mapban_results', compact('mapban', 'maps'));
    }

}
