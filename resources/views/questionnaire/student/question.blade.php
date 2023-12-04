@extends('student.layout.app')
@section('content')
    <div class="main-content pt-lg-4">
        <div class="m-2">
            <h2 class="mb-0 d-flex justify-content-between">
                {{$assessment->name}}
            </h2>
            <span>{{$module->name}}</span>
        </div>
        <span class="m-2">
            {{(!$question?->answer?->is_correct && $question?->answer?->is_opened) ? "You previously incorrectly answered this question." : null}}
        </span>
        <div class="w-100 h-100 mx-2 p-2" style="background-color: #f5f5f4">
            <div class="my-5" id="question-body">
                <h5>{!! $question->body !!}</h5>
            </div>

        </div>
        @include($viewPath, [$question])
    </div>
@endsection
