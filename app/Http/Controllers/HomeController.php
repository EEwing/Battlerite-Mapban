<?php

namespace App\Http\Controllers;

use App\Events\MapBanned;
use App\Map;
use App\MapBan;
use App\MapBanSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function createSession() {
        return view('createSession');
    }

    public function storeSession(Request $request) {
        $this->validate($request, [
            'team1Name' => 'required|max:25',
            'team2Name' => 'required|max:25'
        ]);
        $mb_session = new MapBanSession();
        $mb_session->team1Name = $request->team1Name;
        $mb_session->team2Name = $request->team2Name;
        $mb_session->owner()->associate(Auth::user());
        $mb_session->save();

        return redirect('/mapbans/' . $mb_session->id);
    }

    public function enterSession(MapBanSession $mapBanSession) {
        if($mapBanSession->finished) {
            return redirect('/mapbans/'.$mapBanSession->id.'/results');
        }
        return view('mapban_enter')->with(['mapban' => $mapBanSession]);
    }

    public function chooseTeam(Request $request, MapBanSession $mapBanSession) {
        $this->validate($request, [
            'team' => 'required'
        ]);
        if(!is_numeric($request->team)) {
            return redirect('/mapbans/'.$mapBanSession->id);
        }
        session([$mapBanSession->id . '-team' => (int)$request->team]);
        return redirect('/mapbans/' . $mapBanSession->id . "/view");
    }

    public function viewSession(Request $request, MapBanSession $mapban) {
        if($mapban->finished) {
            return redirect('/mapbans/'.$mapban->id.'/results');
        }
        if(!$request->session()->has($mapban->id . '-team')) {
            return redirect('/mapbans/' . $mapban->id);
        }

        $maps = Map::all();
        $team = session($mapban->id.'-team');
        return view('mapban', compact('mapban', 'maps', 'team'));
    }

    public function banMap(Request $request, MapBanSession $mapBanSession) {
        $team = session($mapBanSession->id."-team", 0);

        $this->validate($request, [
            'map_id' => 'required',
        ]);

        if(!Auth::check()) {
            return "You must be logged in to ban a map";
        }

        if(!$request->session()->has($mapBanSession->id . "-team")) {
            return "You must choose a team before banning a map";
        }

        if($team == 0) {
            return "Spectators can't ban maps";
        }

        if($mapBanSession->finished) {
            return "Map banning phase has finished!";
        }

        if($team != $mapBanSession->current_team) {
            return "It is not your team's turn to ban!";
        }
        $bannedMaps = $mapBanSession->bans;
        foreach($bannedMaps as $map) {
            if($map->id == $request->map_id) {
                return "That map is already banned";
            }
        }

        $ban = new MapBan();
        $ban->map_id = $request->map_id;
        $ban->map_ban_session_id = $mapBanSession->id;
        $ban->banned_by = session($mapBanSession->id . "-team");
        $ban->save();

        $mapBanSession->fresh();
        $mapCount = Map::all()->count();
        $bansCount = $mapBanSession->bans()->count();

        if($bansCount >= $mapCount-1) {
            $mapBanSession->finished = 1;
            foreach(Map::all() as $map) {
                if(!$bannedMaps->contains($map)) {
                    $mapBanSession->chosen_map = $map->id;
                    break;
                }
            }
        }

        if($team == 1) {
            $mapBanSession->current_team = 2;
        } else {
            $mapBanSession->current_team = 1;
        }

        $mapBanSession->save();

        $map = Map::where('id', '=', $ban->map_id)->first();

        event(new MapBanned($map, $mapBanSession));

        return "success";
    }

    public function viewResults(Request $request, MapBanSession $mapban) {
        if(!$mapban->finished) {
            return redirect('/mapbans/'.$mapban->id);
        }

        $maps = Map::all();
        return view('mapban_results', compact('mapban', 'maps'));
    }
}
