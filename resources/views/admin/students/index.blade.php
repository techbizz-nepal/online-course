@extends('admin.layout.app')
@section('students', 'active')
@section('content')
    <div class="main-content pt-lg-4">
        <h2 class="m-2 mb-0 d-flex justify-content-between">
            <span>All Students</span>
            <a href="{{ route('admin.student.create') }}" class="btn btn-primary">Add New Student</a>
        </h2>
        <div class="w-100 h-100 bg-white mx-2 p-2">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center" style="width: 30%;">Student</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">PDF File</th>
                    <th class="text-center">Action</th>
                </tr>
                </thead>
                <tbody>
                @if(count($students->items()) > 0)
                    @foreach($students->items() as $student)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $student->name }}</td>
                            <td>{{$student->email}}</td>
                            <td>
                                <a
                                    href="{{ asset($student->pdf) }}"
                                    class="btn btn-blueLight"
                                    target="_blank"
                                >
                                    View File
                                </a>
                            </td>
                            {{--                    <td class="text-center">--}}
                            {{--                        {!! QrCode::format('svg')->size(100)->generate(asset($student->pdf)); !!}--}}
                            {{--                    </td>--}}
                            <td class="text-center">
                                <a href="{{ route('admin.student.qr', $student) }}" class="btn btn-secondary mb-1">Download
                                    QR</a>
                                <a href="{{ route('admin.student.edit', $student) }}" class="btn btn-info mb-1">Edit</a>
                                <a href="javascript:void(0)"
                                   onclick="document.getElementById('deleteStudent{{ $loop->iteration }}').submit();"
                                   class="btn btn-danger">Delete</a>
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
