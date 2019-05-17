@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (empty($current_game))
                        <form method="post" action="{{ route('games_store') }}">
                            @csrf
                            <button class="btn btn-lg btn-primary">Start a game</button>
                        </form>
                    @else
                        <form method="post" action="{{ route('games_answer') }}">
                            @csrf
                            <div class="row col-md-12">
                                <h4>{{ $current_question->question->content }} ({{ $current_question->question->points }} points)</h4>
                                @if ($current_question->is_answered)
                                    @if ($current_question->is_correctly_answered)
                                        <h4 class="col-md-12 text-success">Right</h4>
                                    @else
                                        <h4 class="col-md-12 text-danger">Wrong</h4>
                                    @endif
                                @endif
                                @foreach($current_question->question->answers as $answer)
                                    <label class="col-md-12 mt-2 @if ($current_question->is_answered && $answer->is_correct) text-success @endif">
                                        @if (!$current_question->is_answered)
                                            <input class="answers_correct form-check-input" type="checkbox" name="answers[]" value="{{ $answer->id }}">
                                        @endif
                                        {{ $answer->content }}
                                    </label>
                                @endforeach
                                <div class="col-md-12">
                                    @if ($current_question->is_answered)
                                        <input type="hidden" name="next" value="1">
                                        <button class="btn btn-primary">@if ($is_last_question) Finish @else Next question @endif</button>
                                    @else
                                        <button name="submit" value="answer" class="btn btn-primary">Answer</button>
                                        <button name="submit" value="interrupt" class="btn btn-danger">Interrupt</button>
                                    @endif
                                </div>
                                @if ($current_question->is_answered)
                                    <h4 class="col-md-12 mt-2">Your score: {{ $current_game->score }}</h4>
                                @endif
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
