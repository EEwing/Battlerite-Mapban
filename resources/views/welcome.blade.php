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

                <form method="POST" action="/storeMapBanSession">
                    <button name="createMapBan" class="btn btn-primary" value="Create New Map Ban"></button>
                </form>
            </div>
        </div>
    </div>
@endsection
