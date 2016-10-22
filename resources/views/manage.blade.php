@extends('layouts.app')

@section('header')
    <script src="/js/clipboard.min.js"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <p>Your Map Ban Session is Ready!</p>

                <small>Copy and paste the following links to the corresponding team captains. Once they enter and both teams ready themselves, the map ban process will begin.</small>

                <div class="list-group manage-group">
                    <div class="list-group-item row">
                        <div class="col-xs-12 text-center">
                            <span>{{$mapban->team1Name}} Link: </span>
                        </div>
                        <div class="col-xs-10">
                            <input id='team1_link' type="text" value="{{$mapban->getLeftTeamLink()}}" readonly />
                        </div>
                        <div class="col-xs-2">
                            <input class="copy-button" type="button" value="Copy" data-clipboard-target="#team1_link"/>
                        </div>
                    </div>
                    <div class="list-group-item row">
                        <div class="col-xs-12 text-center">
                            <span>Spectator Link: </span>
                        </div>
                        <div class="col-xs-10">
                            <input id='spec_link' type="text" value="{{$mapban->getSpectatorLink()}}" readonly />
                        </div>
                        <div class="col-xs-2">
                            <input class="copy-button" type="button" value="Copy" data-clipboard-target="#spec_link"/>
                        </div>
                    </div>
                    <div class="list-group-item row">
                        <div class="col-xs-12 text-center">
                            <span>{{$mapban->team2Name}} Link: </span>
                        </div>
                        <div class="col-xs-10">
                            <input id='team2_link'type="text" value="{{$mapban->getRightTeamLink()}}" readonly />
                        </div>
                        <div class="col-xs-2">
                            <input class="copy-button" type="button" value="Copy" data-clipboard-target="#team2_link"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        new Clipboard('.copy-button');
    </script>
@endsection
