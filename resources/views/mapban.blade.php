@extends('layouts.app')

@section('header')
    <script>
        var stage = {{$mapban->stage}};
        var current_team = {{$mapban->current_team}};
        var statusBox;
        $(document).ready(function() {
            statusBox = $('#status');
            console.log("setting up listener");
            Echo.channel('map_ban_{{$mapban->id}}')
                    .listen('MapBanned', event => {
                        console.log(event);
                        var map = $('#map-' + event.map.id);
                        map.addClass('banned');

                        if(event.mapban.finished) {
                            window.location.href = "/mapban/{{$mapban->id}}/results";
                            return;
                        }

                        current_team = event.mapban.current_team;
                        if(event.mapban.stage != stage) {
                            stage = event.mapban.stage;
                        }
                        updateStage();
                    }).listen('TeamReady', event => {
                        console.log(event);
                        switch(event.team) {
                            case 1:
                                leftTeamReady();
                                break;
                            case 2:
                                rightTeamReady();
                                break;
                            default:
                                break;
                        }
                        updateStage();
                    });
        });

        function leftTeamReady() {
            console.log('readying left team');
            $('#left-team-name').removeClass('selected').addClass('ready');
            $('#left-team-container').find('input').remove();
        }
        function rightTeamReady() {
            console.log('readying right team');
            $('#right-team-name').removeClass('selected').addClass('ready');
            $('#right-team-container').find('input').remove();
        }
        function updateStage() {
            console.log('Updating stage: ' + stage + ' and ' + current_team);
            switch (stage) {
                case 0:
                    break;
                case 1:
                    if(current_team == {{$team}}) {
                        statusBox.text('Choose a map to ban!');
                    } else {
                        statusBox.text('Waiting for opponent to choose map');
                    }
                    break;
            }
        }
    </script>
@endsection

@section('content')
    <style>
        .spaced {
            padding-left: 40px;
            padding-right:40px;
        }
    </style>
    <div class="container-fluid banContainer">
        <div class="row">
            <div class="col-xs-3 text-right" id="left-team-container">
                @if($mapban->team1Ready)
                    <span class="h1 spaced dark-ui col-xs-5 ready" id="left-team-name">{{$mapban->team1Name}}</span>
                @else
                    @if($team == 1)
                        <span class="h1 spaced dark-ui col-xs-5 selected" id="left-team-name">{{$mapban->team1Name}}</span>
                        <input type="button" class="btn btn-default ready" value="Ready" />
                    @else
                        <span class="h1 spaced dark-ui col-xs-5" id="left-team-name">{{$mapban->team1Name}}</span>
                    @endif
                @endif
            </div>
            <div class="col-xs-6 text-center">
                @if($mapban->stage == 0)
                    @if(($team == 1 && $mapban->team1Ready) || ($team == 2 && $mapban->team2Ready))
                        <h1 id="status">Waiting for opponent to ready</h1>
                    @elseif($team == 0)
                        <h1 id="status">Waiting for players to ready</h1>
                    @else
                        <h1 id="status">Click 'Ready' to ready up!</h1>
                    @endif
                @elseif ($mapban->stage ==1)
                    @if($team == 0)
                        <h1 id="status">{{$mapban->current_team==1 ? $mapban->team1Name : $mapban->team2Name}}'s turn to ban a map</h1>
                    @elseif($team == 1 || $team == 2)
                        <h1 id="status">{{$mapban->current_team==$team ? 'Choose a map to ban!' : 'Waiting for opponent to choose map'}}</h1>
                    @endif
                @else
                    <h1 id="status"></h1>
                @endif
                <h3 class="col-xs-12 text-center" id="message-box" style="display:none"></h3>
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
                <div class="col-xs-12 text-left dark-ui">
                    <h3>How does this work?</h3>
                    <hr>
                    <p>This page is where you will alternate turns with your opponent, systematically removing maps from the map pool until one final map is selected.</p>
                    <p>The left team above starts with their choice of map to ban, then turns alternate until one map is left.
                        After all maps have been selected, you will be redirected to a page that lists the results of the map banning process</p>
                </div>
            </div>
            <div class="col-xs-3 text-left" id="right-team-container">
                @if($mapban->team2Ready)
                    <span class="h1 spaced dark-ui col-xs-5 ready" id="right-team-name">{{$mapban->team2Name}}</span>
                @else
                    @if($team == 2)
                        <span class="h1 spaced dark-ui col-xs-5 selected" id="right-team-name">{{$mapban->team2Name}}</span>
                        <input type="button" class="ready btn btn-default" value="ready" />
                    @else
                        <span class="h1 spaced dark-ui col-xs-5" id="right-team-name">{{$mapban->team2Name}}</span>
                    @endif
                @endif
            </div>
        </div>
    </div>

@if($team != 0)
    <script>
        var baseLink = "/mapbans/{{$mapban->id}}";
        $('#chooseTeam').click(function() {
            window.location.href = baseLink;
        });
        $('.mapItem').click(function() {
            console.log('sending map ban');
            $this = $(this);
            $.post(window.location.pathname + '/banMap', {
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
        $('.ready').click(function() {
            $.post(window.location.pathname + '/ready')
                    .done(function (data){
                        if(data == "success") {
                            console.log('Team Successfully readied');
                        } else {
                            console.log('Could not ready: ' + data);
                        }
                    }).fail(function(data) {
                        console.error(data.responseText);
            });
        });
    </script>
@endif
@endsection
