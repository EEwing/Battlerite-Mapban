@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <form method="POST" action="/store">
                    <div class="ban-settings">
                        <h3>Create New Map Ban</h3>
                        <hr />

                            <div class="form-group row">
                                <label for="team1Name" class="col-xs-2 col-form-label">Team 1</label>
                                <div class="col-xs-10">
                                    <input type="text" id="team1Name" class="form-control" name="team1Name" placeholder="Team Name" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="team2Name" class="col-xs-2 col-form-label">Team 2</label>
                                <div class="col-xs-10">
                                    <input type="text" id="team2Name" class="form-control" name="team2Name" placeholder="Team Name" />
                                </div>
                            </div>
                    </div>
                    <input type="submit" class="btn btn-default col-xs-4 pull-right" value="Create" />
                </form>
            </div>
        </div>
    </div>
@endsection
