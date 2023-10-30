@extends('admin.layout.app')
@section('content')
    <div class="main-content pt-lg-4">
        <h2 class="m-2 mb-0 d-flex justify-content-between">
            <span>Edit {{\App\Enums\Questionnaire\QuestionType::from($question["type"])->value()}}</span>
        </h2>
        <div class="w-100 h-100 bg-white mx-2 p-2">
            <form
                action="{{ route('admin.courses.assessments.modules.questions.update', $routeParams) }}"
                method="POST"
                id="questionForm">
                @csrf
                @method('PATCH')
                @if($question->getAttribute('type') == $types["closeOption"])
                    @include('questionnaire.admin.questions.types.closed-option.edit', ['question'=>$question])
                @elseif($question["type"] == $types["readAndAnswer"])
                    @include('questionnaire.admin.questions.types.read-and-answer.edit')
                @elseif($question["type"] == $types["describeImage"])
                    describe image
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
