@extends('layouts.app')

@section('content')
    <style>
        .spaced {
            padding-left: 40px;
            padding-right:40px;
        }
        .cross-out {
            position:absolute;
            top:0px;
            left:0px;
            width:100%;
            height:100%;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 text-center">
                <h1>YOU'VE SELECTED</h1>
            </div>

            <div class="col-xs-12">
                <div class="col-xs-12">
                    <div class="col-xs-6 col-xs-offset-3 text-center dark-ui">
                        <h1>{{$mapban->chosenMap->name}}</h1>
                        <img src="{{$mapban->chosenMap->picture}}" width="100%">
                    </div>
                </div>
                <div class="col-xs-5">
                    <h2 class="selected dark-ui text-center">{{$mapban->team1Name}}</h2>
                    @foreach($mapban->bans()->where('banned_by', '=', 1)->get() as $map)
                        <div class="col-xs-10 pull-left">
                            <div class="mapItem dark-ui">
                                <h3>{{$map->name}}</h3>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-xs-5 pull-right">
                    <h2 class="selected dark-ui text-center">{{$mapban->team2Name}}</h2>
                    @foreach($mapban->bans()->where('banned_by', '=', 2)->get() as $map)
                        <div class="col-xs-10 pull-right">
                            <div class="mapItem dark-ui">
                                <h3>{{$map->name}}</h3>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
