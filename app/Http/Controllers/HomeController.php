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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mapbans = MapBanSession::limit(20)->get();
        return view('home', compact('mapbans'));
    }
}
