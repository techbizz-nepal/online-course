@php
    @endphp
@extends('admin.layout.app')
@section('content')
    <div class="main-content pt-lg-4">
        <h2 class="m-2 mb-0 d-flex justify-content-between">
            <span>Add New Question</span>
        </h2>
        <div class="w-100 h-100 bg-white mx-2 p-2">
            <form
                action="{{ route('admin.courses.assessments.modules.questions.update', ['course'=>$course->slug, 'assessment' => $assessment->slug, "module" => $module->slug, "question" => $question->id]) }}"
                method="POST"
                id="questionForm">
                @csrf
                @method('PATCH')
                <div class="form-group row">
                    <div class="col-12">
                        <label for="text">Question Text</label>
                        <textarea class="form-control @error('text') is-invalid @enderror"
                                  name="text"
                                  id="text" rows="2">{{$question->getAttribute('body') ?? @old('text')}}</textarea>
                        @error('text')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                @if($question->getAttribute('type') == $types["closeOption"])
                    @include('questionnaire.admin.questions.types.closed-option.edit', ['options'=>$question->options])
                @elseif($question["requestType"] == $types["readAndAnswer"])
                    read and answer
                @elseif($question["requestType"] == $types["describeImage"])
                    describe image
                @else
                    no question type
                @endif
                <div class="row">
                    <div class="col-md-12 text-left">
                        <button class="btn btn-primary" type="submit">Save</button>
                        <a href="{{ route('admin.courses.assessments.modules.show', ['course' => $course->slug, 'assessment'=>$assessment->slug,  "module" => $module->slug]) }}"
                           class="btn btn-primary"
                           type="submit">Back</a>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection
