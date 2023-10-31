@extends('student.layout.app')
@section('content')
    <div class="main-content pt-lg-4">
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
                <tr>
                    <th scope="row">1</th>
                    <td>Course title</td>
                    <td>status</td>
                    <td class="text-center">
                        <button class="btn btn-primary">Open Course</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection
