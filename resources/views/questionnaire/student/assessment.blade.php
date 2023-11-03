@extends('student.layout.app')
@section('content')
    <div class="main-content pt-lg-4">
        <h2 class="m-2 mb-0 d-flex justify-content-between">
            <span>Assessment: {{$assessment->name}}</span>
        </h2>
        <div class="w-100 h-100 mx-2 p-2" style="background-color: #f5f5f4">
            <div>
                About this activity
                You are required to answer {{$assessment->questions_count}} questions.
            </div>
            <hr>
            <div>
                This unit is comprised of {{$assessment->modules_count}} modules as follows:
                @isset($assessment->modules)
                    @foreach($assessment->modules as $module)
                        <p>{{ str()->title($module->name) }}</p>
                    @endforeach
                @endif
            </div>
            <div class="mt-5">
                <h3>Please peruse the following learning material for this activity.</h3>
                <img src="{{asset('assets/images/pdf.png')}}" width="20px" alt="{{$assessment->name}}"/>
                <a target="_blank" href="{{asset(sprintf('%s/%s',\App\DTO\Questionnaire\AssessmentData::PUBLIC_PATH,$assessment->material))}}">
                    {{str()->title($assessment->name)}}
                </a>
            </div>
        </div>
        <div class="w-100 h-100 bg-white mx-2 p-2">
            <table class="table table-striped table-bordered" style="font-size: small;">
                <thead>
                <tr>
                    <th class="text-center" style="width: 2%;">Modules</th>
                    <th class="text-center" style="width: 2%;">Answered</th>
                    <th class="text-center" style="width: 2%;">Incorrect</th>
                    <th class="text-center" style="width: 2%;">To Review</th>
                    <th class="text-center" style="width: 2%;">Navigate</th>
                </tr>
                </thead>
                <tbody>
                @isset($assessment->modules)
                    @foreach($assessment->modules as $module)
                        <tr>
                            <td style="width: 30%" class="text-center">
                                <p>{{str()->title($module['name'])}}</p>
                                <p>{{$module->questions->count()}}</p>
                            </td>
                            <td style="width: 30%" class="text-center">
                                <p>9</p>
                            </td>
                            <td style="width: 10%" class="text-center">3</td>
                            <td style="width: 10%" class="text-center">0</td>
                            <td style="width: 20%" class="text-center">
                                <a href="{{route('student.moduleStart', [$course, $assessment, $module])}}">
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
