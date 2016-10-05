<?php

namespace App\Http\Controllers;

use App\Map;
use App\MapBanSession;
use Illuminate\Http\Request;

use App\Http\Requests;

class AdminController extends Controller
{
    public function index() {
        $maps = Map::all();
        $recent_sessions = MapBanSession::all();
        return view('admin.index', compact('maps', 'recent_sessions'));
    }

    public function storeMap(Request $request) {
        $this->validate($request, [
            "mapName" => 'required',
            'mapPicture' => 'required|url'
        ]);

        $map = new Map();
        $map->name = $request->mapName;
        $map->picture = $request->mapPicture;
        $map->save();

        return back();
    }
}
