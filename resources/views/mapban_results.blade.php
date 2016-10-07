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
                <span class="h1 spaced">{{$mapban->team1Name}}</span>
                <span class="h3">VS.</span>
                <span class="h1 spaced">{{$mapban->team2Name}}</span>
            </div>

            <div class="col-xs-12">
                <div class="col-xs-12">
                    <div class="col-xs-6 col-xs-offset-3 text-center">
                        <h1>{{$mapban->chosenMap->name}}</h1>
                        <img src="{{$mapban->chosenMap->picture}}" width="100%">
                    </div>
                </div>
                @foreach($maps as $map)
                    @if($map->id != $mapban->chosenMap->id)
                        <div class="col-xs-4 mapItem" id="map-{{$map->id}}" data-id="{{$map->id}}">
                            <h3>{{$map->name}}</h3>
                            <div class="col-xs-12">
                                <img src="{{$map->picture}}" width="100%" />
                                @if($mapban->bans->contains($map))
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/8/8b/Red_X_Freehand.svg" class="cross-out"/>
                                @else
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/8/8b/Red_X_Freehand.svg" class="cross-out"style="display:none" />
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection
