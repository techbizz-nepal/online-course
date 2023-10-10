@extends('admin.layout.app')
@section('courses', 'active')
@section('content')
    <div class="main-content pt-lg-4">
        {{-- Course Section       --}}
        <h2 class="m-2 mb-0 d-flex justify-content-between">
            <span>{{$title}}</span>
        </h2>
        <div class="w-100 h-100 bg-white mx-2 p-2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-5 col-sm-12">
                        <img
                            alt="{{ $title }}"
                            src="{{ asset('storage/images/courses/'.$image) }}"
                            class="img-thumbnail"
                            style="object-fit: cover; object-position: center;">
                    </div>
                    <div class="col-md-7 col-sm-12">
                        <div class="row py-2">
                            {!! $description !!}
                        </div>
                        <div class="row py-4 bg-secondary text-white meta-details">
                            <div class="col-6">
                                Fee Detail: {{$fee_details}}
                            </div>
                            <div class="col-6">
                                Course Length: {{$course_length}}
                            </div>
                        </div>
                        <div class="row py-4 bg-secondary text-white meta-details">
                            <div class="col-6">
                                Area: {{$study_area}}
                            </div>
                            <div class="col-6">
                                Campus: {{$campus}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Assessment Section        --}}
        <h2 class="m-2 mb-0 d-flex justify-content-between">
            <span>Assessments</span>
            <a href="" class="btn btn-primary">Add New Assessment</a>
        </h2>
        <div class="w-100 h-100 bg-white mx-2 p-2">
            <div class="container-fluid">
                <div class="row font-weight-bold">
                    <div class="col-3">Title</div>
                    <div class="col-3">Status</div>
                    <div class="col-3">Created At</div>
                    <div class="col-3">Action</div>
                </div>
            </div>
        </div>
    </div>
@endsection
