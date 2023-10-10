@extends('admin.layout.app')
@section('courses', 'active')
@section('content')
    <div class="main-content pt-lg-4">
        <h2 class="m-2 mb-0 d-flex justify-content-between">
            <span>All Courses</span>
            <a href="{{ route('admin.course.create') }}" class="btn btn-primary">Add New Course</a>
        </h2>
        <div class="w-100 h-100 bg-white mx-2 p-2">
            <table class="table table-striped table-bordered" style="font-size: small;">
                <thead>
                <tr>
                    <th class="text-center" style="width: 2%;">#</th>
                    <th class="text-center" style="width: 5%;">Code</th>
                    <th class="text-center" style="width: 10%;">Category</th>
                    <th class="text-center" style="width: 15%;">Course</th>
                    <th class="text-center" style="width: 10%;">Price</th>
                    <th class="text-center" style="width: 10%;">Course Length</th>
                    <th class="text-center" style="width: 10%;">Campus</th>
                    <th class="text-center" style="width: 10%;">Action</th>
                </tr>
                </thead>
                <tbody>
                @if($courses->isNotEmpty())
                @foreach($courses->items() as $course)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td class="text-center">{{ $course->course_code }}</td>
                    <td class="text-center">{{ $course->category->name }}</td>
                    <td class="text-center">{{ $course->title }}</td>
                    <td class="text-center">${{ $course->price }}</td>
                    <td class="text-center">{{ $course->course_length }}</td>
                    <td class="text-center">{{ $course->campus }}</td>
                    <td class="text-center">
                        <button href="#" class="btn btn-secondary mb-1" data-toggle="modal" data-target="#bookingDateModalLong{{ $loop->iteration }}">Booking Dates</button>
                        <a href="{{ route('admin.course.edit', $course) }}" class="btn btn-info mb-1">Edit</a>
                        <a href="javascript:void(0)" onclick="document.getElementById('deleteCourse{{ $loop->iteration }}').submit();" class="btn btn-danger">Delete</a>
                        <form action="{{ route('admin.course.destroy', $course) }}" class="d-none" method="POST" id="deleteCourse{{ $loop->iteration }}">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                <div class="modal fade" id="bookingDateModalLong{{ $loop->iteration }}" tabindex="-1" role="dialog" aria-labelledby="bookingDateModalLongTitle" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="bookingDateModalLongTitle">Booking Dates For {{ $course->title }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12 mx-3">
                                        <ul>
                                            @if($course->booking_dates_count > 0)
                                            @foreach ($course->bookingDates as $date)
                                            <li>{{ $date->booking_date }}</li>
                                            @endforeach
                                            @else
                                            <li>No Booking Date Selected For This Course.</li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
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
