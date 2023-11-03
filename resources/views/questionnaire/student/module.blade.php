@extends('student.layout.app')
@section('content')
    <div class="main-content pt-lg-4">
        <h2 class="m-2 mb-0 d-flex justify-content-between">
            <span>{{$module->name}}</span>
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
                   href="{{asset(sprintf('%s/%s',\App\DTO\Questionnaire\AssessmentData::PUBLIC_PATH,$assessment->material))}}">
                    {{str()->title($assessment->name)}}
                </a>
            </div>
        </div>
        <div class="w-100 h-100 bg-white mx-2 p-2">
            <table class="table table-striped table-bordered" style="font-size: small;">
                <thead>
                <tr>
                    <th scope="row">#</th>
                    <th class="text-center" style="width: 2%;">Questions in this module</th>
                    <th class="text-center" style="width: 2%;">Status</th>
                    <th class="text-center" style="width: 2%;">Action</th>
                </tr>
                </thead>
                <tbody>
                @isset($module->questions)
                    @foreach($module->questions as $questions)
                        <tr>
                            <td style="width: 10%">{{$loop->iteration}}</td>
                            <td style="width: 70%">
                                <p class="mb-2">{{str()->title($module->name)}}</p>
                                <p>{{str()->title($questions['body'])}}</p>
                            </td>
                            <td style="width: 10%">
                                <p>correctly answered</p>
                            </td>
                            <td style="width: 10%" class="text-center">
                                <a href="{{route('student.moduleStart', [$course, $assessment, $module, $module->qustion])}}">
                                    <button class="btn btn-primary">retake</button>
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

