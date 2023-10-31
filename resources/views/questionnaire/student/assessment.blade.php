@extends('student.layout.app')
@section('content')
    <div class="main-content pt-lg-4">
        <h2 class="m-2 mb-0 d-flex justify-content-between">
            <span>Assessment: {{$assessment->name}}</span>
        </h2>
        <div class="w-100 h-100 mx-2 p-2" style="background-color: #f5f5f4">
            <div>
                About this activity
                You are required to answer 114 questions.
            </div>
            <hr>
            <div>
                This unit is comprised of {{$assessment->modules->count()}} modules as follows:
                @foreach($assessment->modules as $module)
                    <p>Module {{$loop->iteration}} - {{ str()->title($module->name) }}</p>
                @endforeach
            </div>
            <div class="mt-5">
                <h3>Please peruse the following learning material for this activity.</h3>
                <img src="{{asset('assets/images/pdf.png')}}" width="20px" alt="{{$module->name}}"/>
                <a target="_blank" href="{{asset(sprintf('%s/%s',\App\DTO\Questionnaire\AssessmentData::PUBLIC_PATH,$assessment->material))}}">
                    {{str()->title($assessment->name)}}
                </a>
            </div>
        </div>
        <div class="w-100 h-100 bg-white mx-2 p-2">
            <table class="table table-striped table-bordered" style="font-size: small;">
                <thead>
                <tr>
                    <th class="text-center" style="width: 2%;">#</th>
                    <th class="text-center" style="width: 2%;">Module</th>
                    <th class="text-center" style="width: 2%;">Status</th>
                    <th class="text-center" style="width: 2%;">Result</th>
                    <th class="text-center" style="width: 2%;">Action</th>
                </tr>
                </thead>
                <tbody>
                @isset($course)
                    @foreach($course->assessments as $assessment)
                        <tr>
                            <th style="width: 10%" class="text-center" scope="row">{{$loop->iteration}}</th>
                            <td style="width: 30%" class="text-center">{{$assessment['name']}}</td>
                            <td style="width: 30%" class="text-center">
                                <p>In Progress</p>
                                <p>9% completed</p>
                            </td>
                            <td style="width: 10%" class="text-center">0%</td>
                            <td style="width: 20%" class="text-center">
                                <a href="{{route('student.startExam', [$course, $assessment])}}">
                                    <button class="btn btn-primary">Start</button>
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
