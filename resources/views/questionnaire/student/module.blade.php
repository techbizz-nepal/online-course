@php
    use \App\Enums\Questionnaire\QuestionType;
@endphp
@extends('student.layout.app')
@section('content')
    <div class="main-content pt-lg-4">
        <h2 class="m-2 mb-0 d-flex justify-content-between">
            <span>{{$module['name']}}</span>
        </h2>
        <div class="w-100 h-100 mx-2 p-2" style="background-color: #f5f5f4">
            <div>
                You are about to begin a new section of your exam...
            </div>
            <hr>
            <div class="mt-5">
                <h3>Please peruse the following learning material for this activity.</h3>
                <img src="{{asset('assets/images/pdf.png')}}" width="20px" alt="{{$assessment->name}}"/>
                <a target="_blank"
                   href="{{asset(sprintf('%s/%s',\App\DTO\Questionnaire\AssessmentData::PUBLIC_PATH,$assessment['material']))}}">
                    {{str()->title($assessment->name)}}
                </a>
            </div>
        </div>
        <div class="w-100 h-100 bg-white mx-2 p-2">
            <table class="table table-striped table-bordered" style="font-size: small;">
                <thead>
                <tr>
                    <th style="width: 5%" scope="row">#</th>
                    <th style="width: 85%">Questions in this module</th>
                    <th style="width: 5%">Status</th>
                    <th style="width: 5%">Action</th>
                </tr>
                </thead>
                <tbody>
                @isset($questions)
                    @foreach($module['questions'] as $question)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>
                                <p class="mb-2">{{str()->title($module['name'])}}</p>
                                <p>{{str()->title($question['body'])}}</p>
                            </td>
                            <td class="inline">
                                @if(count($question['answers']) && in_array($question->type, QuestionType::getCorrectTypes()))
                                    @if($question['answers'][0]['is_correct'])
                                        <p>correctly answered</p>
                                    @else
                                        <p>incorrectly answered</p>
                                    @endif
                                @elseif(count($question['answers']))
                                    <p>answered</p>
                                @else
                                    <p>new</p>
                                @endif
                            </td>
                            <td>
                                @if(count($question['answers']))
                                    @if(in_array($question->type, QuestionType::getCorrectTypes()) && !$question['answers'][0]['is_correct'])
                                        <a href="{{route('student.openQuestion', [$course, $assessment, $module['slug'], $question['id'], $exam])}}">
                                            <button class="btn btn-primary">retake</button>
                                        </a>
                                    @endif
                                @else
                                    <a href="{{route('student.openQuestion', [$course, $assessment, $module['slug'], $question['id'], $exam])}}">
                                        <button class="btn btn-primary">open</button>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>

@endsection

