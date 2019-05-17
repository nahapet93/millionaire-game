@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body text-center">
                        @if (!empty($top_games))
                            <h2>Top scores:</h2>
                            @foreach ($top_games as $top_game)
                                <hr />
                                <div class="col-md-12">
                                    <h4>{{ $top_game->user->name }} ({{ $top_game->ms }} points)</h4>
                                </div>
                            @endforeach
                        @else
                            <h2>Top scores are empty</h2>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection