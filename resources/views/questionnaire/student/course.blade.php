@extends('student.layout.app')
@section('content')
    <div class="main-content pt-lg-4">
        <h2 class="m-2 mb-0 d-flex justify-content-between">
            <span>Course: {{$course->title}}</span>
        </h2>
        <div class="w-100 h-100 bg-white mx-2 p-2">
            <table class="table table-striped table-bordered" style="font-size: small;">
                <thead>
                <tr>
                    <th class="text-center" style="width: 2%;">#</th>
                    <th class="text-center" style="width: 2%;">Assessment</th>
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
