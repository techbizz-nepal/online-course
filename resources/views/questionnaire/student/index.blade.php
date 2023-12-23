@extends('student.layout.app')
@section('dashboard', 'active')
@section('content')
    <div class="main-content pt-lg-4 ">
        <h2 class="m-2 mb-0 d-flex justify-content-between">
            <span>My Enrollments</span>
        </h2>

        <div class="w-100 h-100 bg-white mx-2 p-2">
            <table class="table table-striped table-bordered" style="font-size: small;">
                <thead>
                <tr>
                    <th class="text-center" style="width: 2%;">#</th>
                    <th class="text-center" style="width: 2%;">Course</th>
                    <th class="text-center" style="width: 2%;">Status</th>
                    <th class="text-center" style="width: 2%;">Action</th>
                </tr>
                </thead>
                <tbody>
                @isset($courses)
                    @foreach($courses as $course)
                        <tr>
                            <th style="width: 10%" class="text-center" scope="row">{{$loop->iteration}}</th>
                            <td style="width: 30%" class="text-center">{{$course['title']}}</td>
                            <td style="width: 30%" class="text-center">status</td>
                            <td style="width: 30%" class="text-center">
                                <a href="{{route('student.startExam', [$course])}}">
                                    <button class="btn btn-primary">Open Course</button>
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
