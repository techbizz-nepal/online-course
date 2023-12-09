@extends('admin.layout.app')
@section('student', 'active')
@section('content')
    <div class="main-content pt-lg-4">
        <h2 class="m-2 mb-0 d-flex justify-content-between">
            <span>Exams taken by {{$student['fullName']}}</span>
        </h2>
        <div class="w-100 h-100 bg-white mx-2 p-2">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th style="width: 30%;">Module</th>
                    <th>Total Answered</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @if(count($exams))
                    @foreach($exams as $exam)

                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{$exam['module']['name']}}</td>
                            <td>{{$exam['exam_question_count']}}</td>
                            <td>
                                <a href="{{route('admin.student.exams.result', [$student['id'], $exam['id']])}}">
                                    <button class="btn btn-info">See Results</button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center" colspan="5">No Data Found</td>
                    </tr>
                @endif

                </tbody>
            </table>
        </div>
    </div>
@endsection
