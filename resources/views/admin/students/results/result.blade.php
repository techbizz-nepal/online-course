@extends('admin.layout.app')
@section('student', 'active')
@section('content')
    <div class="main-content pt-lg-4">
        <h2 class="m-2 mb-0 d-flex justify-content-evenly">
            <a href="{{route('admin.student.exams', [$exam['student_id']])}}" class="mr-2 py-2 px-4 bg-primary rounded text-white">
                <i class="fas fa-arrow-left"></i>
            </a>
            <p class="mr-2 p-2">Answers submitted for {{str()->title($exam['module']['name'])}} Module</p>
        </h2>
        <div class="w-100 h-100 bg-white mx-2 p-2">
            @isset($exam->examQuestion)
                @foreach($exam->examQuestion as $question)
                    <x-questionnaire.admin.answered-question :$question>
                        <x-questionnaire.admin.answered-type :$question></x-questionnaire.admin.answered-type>
                    </x-questionnaire.admin.answered-question>
                @endforeach
            @endisset

        </div>
    </div>
@endsection
