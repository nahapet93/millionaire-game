@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        <form method="post" action="{{ route('questions_update', $question->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group row">
                                <label for="content" class="col-md-4 col-form-label">Question content</label>

                                <div class="col-md-12">
                                    <textarea class="form-control" id="content" name="content">{{ $question->content }}</textarea>

                                    @if ($errors->has("content"))
                                        <span class="text-danger" role="alert">
                                            <strong>This field is required</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="points" class="col-md-4 col-form-label">Points</label>

                                <div class="col-md-6">
                                    <select class="form-control" id="points" name="points">
                                        @foreach ($points as $point)
                                            <option value="{{ $point }}" @if($question->points == $point) selected @endif>{{ $point }}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has("points"))
                                        <span class="text-danger" role="alert">
                                            <strong>This field is required</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label">Answers</label>
                            </div>
                            @foreach ($answers as $i => $answer)
                                <div class="form-group row">
                                    <div class="col-md-10">
                                        <textarea class="answers_content form-control" name="answers[content][]">{{ $answer->content }}</textarea>

                                        @if ($errors->has("answers.content.$i"))
                                            <span class="text-danger" role="alert">
                                                <strong>This field is required</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-md-1">
                                        <input type="hidden" name="answers[correct][{{ $i }}]" value="0">
                                        <input class="answers_correct form-check-input" id="correct_{{ $i }}" type="checkbox" @if($answer->is_correct == 1) checked @endif name="answers[correct][{{ $i }}]" value="1">
                                        <label class="form-check-label" for="correct_{{ $i }}">Correct</label>
                                    </div>
                                </div>
                            @endforeach
                            <div class="form-group row">
                                <div class="col-md-8">
                                    <button type="submit" class="btn btn-primary">
                                        Update
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection