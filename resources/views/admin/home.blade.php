@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        <form method="post" action="{{ route('questions_store') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="content" class="col-md-4 col-form-label">Question content</label>

                                <div class="col-md-12">
                                    <textarea class="form-control" id="content" name="content">{{ old('content') }}</textarea>

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
                                        <option value="{{ $point }}" @if(old('points') == $point) selected @endif>{{ $point }}</option>
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
                            @for ($i = 0; $i < 4; $i++)
                            <div class="form-group row">
                                <div class="col-md-10">
                                    <textarea class="answers_content form-control" name="answers[content][]">{{ old("answers.content.$i") }}</textarea>

                                    @if ($errors->has("answers.content.$i"))
                                    <span class="text-danger" role="alert">
                                        <strong>This field is required</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-1">
                                    <input type="hidden" name="answers[correct][{{ $i }}]" value="0">
                                    <input class="answers_correct form-check-input" id="correct_{{ $i }}" type="checkbox" name="answers[correct][{{ $i }}]" value="1">
                                    <label class="form-check-label" for="correct_{{ $i }}">
                                        Correct
                                    </label>
                                </div>
                            </div>
                            @endfor
                            <div class="form-group row">
                                <div class="col-md-8">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </form>

                        @foreach ($questions as $question)
                        <div class="row col-md-12">
                            <h4>{{ $question->content }} ({{ $question->points }} points)</h4>
                            <div class="col-md-12">
                                <a href="/questions/edit/{{ $question->id }}" class="btn btn-info">Edit</a>
                                <form class="d-inline-block" action="{{ route('questions_destroy', $question->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                            @foreach ($question->answers as $answer)
                            <div class="col-md-12 mt-2 @if($answer->is_correct) text-success @endif">
                                {{ $answer->content }}
                            </div>
                            @endforeach
                        </div>
                        <hr/>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection