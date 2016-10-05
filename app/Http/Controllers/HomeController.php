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
            'team1Name' => 'required|max:200',
            'team2Name' => 'required|max:200',
        ]);
        $mb_session = new MapBanSession();
        $mb_session->team1Name = $request->team1Name;
        $mb_session->team1Logo = $request->team1Logo;
        $mb_session->team2Name = $request->team2Name;
        $mb_session->team2Logo = $request->team2Logo;
        $mb_session->owner()->associate(Auth::user());
        $mb_session->save();

        return redirect('/mapbans/' . $mb_session->id);
    }

    public function enterSession(MapBanSession $mapBanSession) {
        return view('mapban_enter')->with(['mapban' => $mapBanSession]);
    }

    public function chooseTeam(Request $request, MapBanSession $mapBanSession) {
        $this->validate($request, [
            'team' => 'required'
        ]);
        session([$mapBanSession->id . '-team' => $request->team]);
        return redirect('/mapbans/' . $mapBanSession->id . "/view");
    }

    public function viewSession(Request $request, MapBanSession $mapBanSession) {
        if(!$request->session()->has($mapBanSession->id . '-team')) {
            return redirect('/mapbans/' . $mapBanSession->id);
        }
        $maps = Map::all();
        return view('mapban')->with(['mapban' => $mapBanSession, 'maps' => $maps, 'team' => session($mapBanSession->id . '-team')]);
    }

    public function banMap(Request $request, MapBanSession $mapBanSession) {
        $this->validate($request, [
            'map_id' => 'required',
        ]);

        if(!Auth::check()) {
            return "You must be logged in to ban a map";
        }

        if(!$request->session()->has($mapBanSession->id . "-team")) {
            return "You must choose a team before banning a map";
        }

        if(session($mapBanSession->id . "-team") == 0) {
            return "Spectators can't ban maps";
        }

        $ban = new MapBan();
        $ban->map_id = $request->map_id;
        $ban->map_ban_session_id = $mapBanSession->id;
        $ban->banned_by = session($mapBanSession->id . "-team");
        //$ban->save();

        $map = Map::where('id', '=', $ban->map_id)->first();
        $mapBan = MapBanSession::where('id', '=', $ban->map_ban_session_id)->first();

        event(new MapBanned($map, $mapBan));

        return "success";
    }
}
