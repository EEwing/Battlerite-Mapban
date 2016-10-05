@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
                        You are logged in!
                    </div>
                </div>
                <div class="col-xs-12">
                    <span class="h2">Maps</span>
                    <input type="button" class="btn btn-primary pull-right" id="toggleMaps" value="v" />
                </div>
                <div id="mapList" class="row" style="display:none">
                    @foreach($maps as $map)
                        <div class="col-xs-6 mapItem">
                            <h3>{{$map->name}}</h3>
                            <img src="{{$map->picture}}" height="200px" />
                        </div>
                    @endforeach
                    <div class="col-xs-12">
                        <form method="POST" action="/admin/storeMap">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="mapName">Map Name</label>
                                <input type="text" id="mapName" name="mapName" class="form-control" placeholder="Map Name" />

                                @if ($errors->has('mapName'))
                                    <span class="text-danger">
                                    <strong>{{ $errors->first('mapName') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="mapPicture">Picture</label>
                                <input type="url" id="mapPicture" name="mapPicture" class="form-control" placeholder="http://mypicture.com" />

                                @if ($errors->has('mapPicture'))
                                    <span class="text-danger">
                                    <strong>{{ $errors->first('mapPicture') }}</strong>
                                </span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary">Create New Map</button>
                        </form>
                    </div>
                </div>

                <div class="col-xs-12">
                    <h2>Recent Map Ban Sessions</h2>
                </div>
                <div class="col-xs-12 list-group">
                    @foreach($recent_sessions as $mapban)
                        <a href="/mapbans/{{$mapban->id}}" class="list-group-item">
                            <h2>{{$mapban->team1Name}} VS. {{$mapban->team2Name}}</h2>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#toggleMaps').click(function(e) {
            e.preventDefault();
            $('#mapList').slideToggle();
            $this = $(this);
            if($this.attr('value') == "v") {
                $this.attr('value', '^');
            } else {
                $this.attr('value', 'v');
            }
        });
    </script>
@endsection
