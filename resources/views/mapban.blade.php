@extends('layouts.app')

@section('header')
    <script>
        $(document).ready(function() {
            console.log("setting up listener");
            Echo.channel('map_banned_{{$mapban->id}}')
                    .listen('MapBanned', event => {
                        console.log(event);
                        var map = $('#map-' + event.map.id);
                        map.addClass('banned');

                        if(event.mapBan.finished) {
                            window.location.href = "/mapbans/{{$mapban->id}}/results";
                            return;
                        }

                        if(event.mapBan.current_team == 0) {

                        } else {

                        }
                    });
        });
    </script>
@endsection

@section('content')
    <style>
        .spaced {
            padding-left: 40px;
            padding-right:40px;
        }
    </style>
    <div class="container banContainer">
        <div class="row">
            <div class="col-xs-12 text-center">
                <h1>SELECT YOUR MAPS</h1>
                <span class="h1">

                </span>
            </div>
            <div class="col-xs-10 col-xs-offset-1 text-center">
                <span class="h1 spaced dark-ui col-xs-5{{ $team==1 ? " current-team" : "" }}">{{$mapban->team1Name}}</span>
                <span class="h3 col-xs-2">VS.</span>
                <span class="h1 spaced dark-ui col-xs-5{{ $team==2 ? " current-team" : "" }}">{{$mapban->team2Name}}</span>
            </div>
            <h3 class="col-xs-12 text-center" id="message-box" style="display:none"></h3>

            <div class="col-xs-12">
                @foreach($maps as $map)
                    <div class="col-xs-4 mapContainer text-center">
                        @if($mapban->bans->contains($map))
                            <div class="mapItem dark-ui banned" id="map-{{$map->id}}" data-id="{{$map->id}}">
                                <h3>{{$map->name}}</h3>
                                <img src="{{$map->picture}}" width="100%"/>
                            </div>
                        @else
                            <div class="mapItem dark-ui" id="map-{{$map->id}}" data-id="{{$map->id}}">
                                <h3>{{$map->name}}</h3>
                                <img src="{{$map->picture}}" width="100%"/>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="col-xs-12">
                <h3>How does this work?</h3>
                <p>This page is where you will alternate turns with your opponent, systematically removing maps from the map pool until one final map is selected.</p>
                <p>The left team above starts with their choice of map to ban, then turns alternate until one map is left.
                    After all maps have been selected, you will be redirected to a page that lists the results of the map banning process</p>
            </div>
        </div>
    </div>

    <script>
        var baseLink = "/mapbans/{{$mapban->id}}";
        $('#chooseTeam').click(function() {
            window.location.href = baseLink;
        });
        $('.mapItem').click(function() {
            console.log('sending map ban');
            $this = $(this);
            $.post(baseLink + '/banMap', {
                map_id: $this.data('id')
            }).done(function(data) {
                if(data != "success") {
                    $('#message-box').text(data).fadeIn().delay(2000).fadeOut();
                }
                console.log('map ban sent: ' + data);
            }).fail(printData);
        });
        function printData(data) {
            w = window.open();
            $(w.document.body).html(data.responseText);
        }
    </script>
@endsection
