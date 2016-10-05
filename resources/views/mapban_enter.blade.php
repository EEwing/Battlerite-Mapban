@extends('layouts.app')

@section('content')
    <style>
        .teamButton {
            font-size: 30px;
        }
    </style>
    <div class="container teamContainer">
        <div class="row text-center team">
            <div class="col-xs-12 text-center">
                <h1>Which team are you on?</h1>
            </div>
            <div class="col-xs-12 col-md-4">
                <input type="button" class="btn btn-primary teamButton" value="{{$mapban->team1Name}}" data-team="1">
            </div>
            <div class="col-xs-12 col-md-4">
                <input type="button" class="btn btn-default teamButton" value="Spectator" data-team="0">
            </div>
            <div class="col-xs-12 col-md-4">
                <input type="button" class="btn btn-primary teamButton" value="{{$mapban->team2Name}}" data-team="2">
            </div>
        </div>
    </div>
    <script>
        $('.teamButton').click(function() {
           $this = $(this);
            var value = $this.data('team');
            var form = $('<form action="/mapbans/{{$mapban->id}}/chooseTeam" method="POST"> <input type="hidden" name="team" value="' + value + '" /></form>');
            $('body').append(form);
            form.submit();
        });
    </script>
@endsection
