@extends('layouts.app')

@section('header')
    <script>
        $(document).ready(function() {
            console.log("setting up listener");
            Echo.channel('map_banned_{{$mapban->id}}')
                    .listen('MapBanned', event => {
                        console.log("New Echo Event: " + event);
                        console.log(event);
                        var map = $('#map-' + event.map.id);
                        console.log(map);
                        var overlay = map.find('.cross-out');
                        console.log(overlay);
                        overlay.fadeIn();
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
            <div class="col-xs-12">
                <span class="h1">
                    @if($team == 0)
                        You are spectating
                    @elseif($team == 1)
                        You are on team {{$mapban->team1Name}}
                    @elseif($team == 2)
                        You are on team {{$mapban->team2Name}}
                    @else
                        Incorrect team found.
                    @endif
                </span>
                <button class="btn btn-primary" id="chooseTeam">Choose another team</button>
            </div>
            <div class="col-xs-12 text-center">
                <span class="h1 spaced">{{$mapban->team1Name}}</span>
                <span class="h3">VS.</span>
                <span class="h1 spaced">{{$mapban->team2Name}}</span>
            </div>

            <div class="col-xs-8 col-xs-offset-2">
                @foreach($maps as $map)
                    <div class="col-xs-6 mapItem" id="map-{{$map->id}}" data-id="{{$map->id}}">
                        <h3>{{$map->name}}</h3>
                        <div class="col-xs-12">
                            <img src="{{$map->picture}}" height="200px" />
                            <img src="https://upload.wikimedia.org/wikipedia/commons/8/8b/Red_X_Freehand.svg" class="cross-out" style="display:none" />
                        </div>
                    </div>
                @endforeach
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
                console.log('map ban sent: ' + data);
            }).fail(printData);
        });
        function printData(data) {
            w = window.open();
            $(w.document.body).html(data.responseText);
        }
    </script>
@endsection
