@extends('student.layout.app')
@section('content')
    <div class="main-content pt-lg-4">
        <h2 class="m-2 mb-0 d-flex justify-content-evenly">
            <a href="{{route('student.courseCover', [$course])}}"
               class="mr-2 py-2 px-4 bg-primary rounded text-white">
                <i class="fas fa-arrow-left"></i>
            </a>
            <span class="mr-2 p-2">Assessment: {{$assessment->name}}</span>
        </h2>
        <div class="w-100 h-100 mx-2 p-2" style="background-color: #f5f5f4">
            <div>
                About this activity
                You are required to answer {{$questionsCount}} questions.
            </div>
            <hr>
            <div>
                This unit is comprised of {{$modulesCount}} modules as follows:
                @isset($modules)
                    @foreach($modules as $module)
                        <p>{{ str()->title($module['name']) }}</p>
                    @endforeach
                @endif
            </div>
            <div class="mt-5">
                <h3>Please peruse the following learning material for this activity.</h3>
                <img src="{{asset('assets/images/pdf.png')}}" width="20px" alt="{{$assessment->name}}"/>
                <a target="_blank"
                   href="{{asset(sprintf('%s/%s',\App\DTO\Questionnaire\AssessmentData::PUBLIC_PATH,$assessment->material))}}">
                    {{str()->title($assessment->name)}}
                </a>
            </div>
        </div>
        <div class="w-100 h-100 bg-white mx-2 p-2">
            <table class="table table-striped table-bordered" style="font-size: small;">
                <thead>
                <tr>
                    <th class="text-center" style="width: 30%;">Modules</th>
                    <th class="text-center" style="width: 20%;">Questions</th>
                    <th class="text-center" style="width: 20%;">Answered</th>
                    <th class="text-center" style="width: 10%;">Status</th>
                    <th class="text-center" style="width: 30%;">Navigate</th>
                </tr>
                </thead>
                <tbody>
                @isset($modules)
                    @foreach($modules as $module)
                        <tr>
                            <td style="width: 30%" class="text-center">
                                <p class="mb-1">{{str()->title($module['name'])}}</p>
                                <p></p>
                            </td>
                            <td style="width: 20%" class="text-center">{{$module['questions_count']}}</td>
                            <td style="width: 20%" class="text-center">{{$module['answered'] ?? 0}}</td>
                            <td style="width: 10%" class="text-center">
                                @if($module['answered'])
                                    <span @class(['text-white', 'text-white', 'py-2', 'px-3', 'rounded-circle', 'bg-flat-color-2'=> $module['pass'], 'bg-flat-color-3'=> !$module['pass']])>
                                        {{$module['pass'] ? 'Pass' : 'Fail'}}
                                    </span>
                                @else
                                    <p>N/A</p>
                                @endif
                            </td>
                            <td style="width: 30%" class="text-center">
                                <a href="{{route('student.moduleStart', [$course, $assessment, $module['slug']])}}">
                                    <button class="btn btn-primary">go to</button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>

@endsection
