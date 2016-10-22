@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 text-center">
            <h3>Use this tool to help choose maps to use for any Battlerite Tournament!</h3>
            <hr>
            <h4>Using this tool is easy and free. Begin the map ban process by clicking the "Create New Ban" button below!</h4>
            <a href="/create">
                <span class="bright-ui btn btn-default h1">Create New Ban</span>
            </a>

        </div>
        <div class="col-md-8 col-md-offset-2 text-left">
            <hr />
            <h2>Recent Map Bans</h2>
            <ul class="list-group dark-ui">
                @foreach($mapbans as $mapban)
                    <a href="/view/{{$mapban->id}}" class="list-group-item">
                        <h1>{{$mapban->team1Name}} VS. {{$mapban->team2Name}}</h1>
                    </a>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
