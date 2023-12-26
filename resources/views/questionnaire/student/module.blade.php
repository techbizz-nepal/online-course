@extends('student.layout.app')
@section('content')
    <div class="main-content pt-lg-4">
        <h2 class="m-2 mb-0 d-flex justify-content-evenly">
            <a href="{{route('student.startExam', [$course])}}"
               class="mr-2 py-2 px-4 bg-primary rounded text-white">
                <i class="fas fa-arrow-left"></i>
            </a>
            <span class="mr-2 p-2">{{$module['name']}}</span>
        </h2>
        <div class="w-100 h-100 mx-2 p-2" style="background-color: #f5f5f4">
            <div>
                You are about to begin a new section of your exam...
            </div>
            <hr>
            <div class="mt-5">
                <h3>Please peruse the following learning material for this activity.</h3>
                <img src="{{asset('assets/images/pdf.png')}}" width="20px" alt="{{$module->name}}"/>
                <a target="_blank"
                   href="{{asset(sprintf('%s/%s',\App\DTO\Questionnaire\ModuleData::PUBLIC_PATH,$module['material']))}}">
                    {{str($module->name)->title()}}
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
                    @foreach($questions as $question)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>
{{--                                <p class="mb-2">{{str()->title($module['name'])}}</p>--}}
                                <p>{!! str()->title($question['body']) !!}</p>
                            </td>
                            <td class="inline">
                                {{$question['status']}}
                            </td>
                            <td>
                                @switch($question['action'])
                                    @case('open')
                                        <a href="{{route('student.openQuestion', [$course, $module['slug'], $question['id'], $exam])}}">
                                            <button class="btn btn-primary">open</button>
                                        </a>
                                        @break
                                    @case('retake')
                                        <a href="{{route('student.openQuestion', [$course, $module['slug'], $question['id'], $exam])}}">
                                            <button class="btn btn-primary">retake</button>
                                        </a>
                                        @break
                                    @case(null)

                                        @break
                                @endswitch
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>

@endsection

