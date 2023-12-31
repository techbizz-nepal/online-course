@extends('admin.layout.app')
@section('student', 'active')
@section('content')
    <div class="main-content pt-lg-4">
        <h2 class="m-2 mb-0 d-flex justify-content-between">
            <span>All Students</span>
            <a href="{{ route('admin.student.create') }}" class="btn btn-primary">Add New Student</a>
        </h2>
        <div class="w-100 h-100 mx-1 p-2 row">
            <form action="{{ route('admin.student.index') }}" class="form-inline">
                <input class="form-control mr-sm-2" type="search" name="query" placeholder="filter by name or email"
                       value="{{request()->get('query')}}">
                <button class="btn btn-primary mr-sm-2" type="submit">Filter</button>
                <a class="btn btn-primary" href="{{route('admin.student.index')}}">Reset</a>
            </form>
        </div>
        <div class="w-100 h-100 bg-white mx-2 p-2">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th style="width: 30%;">Student</th>
                    <th>Email</th>
                    <th>Exam Taken</th>
                    <th>QR</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @if($students->isNotEmpty())
                    @foreach($students->items() as $student)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $student->first_name }} {{$student->surname}}</td>
                            <td>{{$student->email}}</td>
                            {{--                            <td>--}}
                            {{--                                <a--}}
                            {{--                                    href="{{ asset($student->pdf) }}"--}}
                            {{--                                    class="btn btn-blueLight"--}}
                            {{--                                    target="_blank"--}}
                            {{--                                >--}}
                            {{--                                    View File--}}
                            {{--                                </a>--}}
                            {{--                            </td>--}}
                            <td>
                                @if($student->exams_count)
                                    <a href="{{route('admin.student.exams', [$student])}}">
                                        {{$student->exams_count }}
                                    </a>
                                @else
                                    None
                                @endif
                            </td>
                            <td>
                                {!! QrCode::format('svg')->size(100)->generate(asset($student->pdf)); !!}
                            </td>
                            <td class="text-center">
                                <a href="{{route('admin.student.show', $student)}}" class="btn btn-outline-success mb-1">View Detail</a>
                                <a href="{{ route('admin.student.edit', $student) }}" class="btn btn-info mb-1">Edit</a>
                                <a href="javascript:void(0)"
                                   onclick="document.getElementById('deleteStudent{{ $loop->iteration }}').submit();"
                                   class="btn btn-danger mb-1">Delete</a>
                                <form action="{{ route('admin.student.destroy', $student) }}" class="d-none"
                                      method="POST" id="deleteStudent{{ $loop->iteration }}">
                                    @csrf
                                    @method('DELETE')
                                </form>
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
            <div class="py-4">
                <a type="button"
                   href="{{$prev_page_url ?? "#"}}"
                   class="{{$prev_page_url ?? "disabled"}} btn btn-primary btn-sm">Previous</a>
                <a type="button"
                   href="{{$next_page_url ?? "#"}}"
                   class="{{$next_page_url ?? "disabled"}} btn btn-primary btn-sm">Next</a>
            </div>
        </div>
    </div>
@endsection
