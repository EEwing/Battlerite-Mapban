@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h2>Create New Map Ban</h2>

                <form method="POST" action="/storeMapBanSession">
                    <h2>Team 1:</h2>
                    <div class="form-group">
                        <label for="team1Name">Team 1 Name</label>
                        <input type="text" id="team1Name" class="form-control" name="team1Name" placeholder="Team Name" />
                    </div>
                    <h2>Team 2:</h2>
                    <div class="form-group">
                        <label for="team2Name">Team Name</label>
                        <input type="text" id="team1Name" class="form-control" name="team2Name" placeholder="Team Name" />
                    </div>
                    <input type="submit" class="btn btn-primary" value="Create New Map Ban" />
                </form>
            </div>
        </div>
    </div>
@endsection
