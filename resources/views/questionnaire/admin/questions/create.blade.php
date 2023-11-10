@extends('admin.layout.app')
@section('content')
    <div class="main-content pt-lg-4">
        <h2 class="m-2 mb-0 d-flex justify-content-between">
            <span>Add New {{\App\Enums\Questionnaire\QuestionType::from($question["type"])->value()}}</span>
        </h2>
        <div class="w-100 h-100 bg-white mx-2 p-2">
            <form
                    action="{{ route('admin.courses.assessments.modules.questions.store', $routeParams) }}"
                    method="POST"
                    id="questionForm">
                @csrf
                @if($question["type"] == $question["types"]["closeOption"] || !$question["type"])
                    @include('questionnaire.admin.questions.types.closed-option.create')
                @elseif($question["type"] == $question["types"]["readAndAnswer"])
                    @include('questionnaire.admin.questions.types.read-and-answer.create')
                @elseif($question["type"] == $question["types"]["describeImage"])
                    @include('questionnaire.admin.questions.types.describe-image.create')
                @elseif($question["type"] == $question["types"]["trueFalse"])
                    @include('questionnaire.admin.questions.types.true-false.create')
                @else
                    no question type
                @endif
                <div class="row">
                    <div class="col-md-12 text-left">
                        <button class="btn btn-primary" type="submit">Save</button>
                        <a href="{{ route('admin.courses.assessments.modules.show', collect($routeParams)->except(['type'])->toArray()) }}"
                           class="btn btn-primary"
                           type="submit">Back</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
