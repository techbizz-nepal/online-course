@extends('admin.layout.app')
@section('courses', 'active')
@section('content')
    <div class="main-content pt-lg-4">
        <h2 class="m-2 mb-0 d-flex justify-content-between">
            <span>{{$courseData->title}}</span>
        </h2>
        <div class="w-100 h-100 bg-white mx-2 p-2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-5 col-sm-12">
                        <img
                            alt="{{ $courseData->title }}"
                            src="{{ asset('storage/images/courses/'.$courseData->image) }}"
                            class="img-thumbnail"
                            style="object-fit: cover; object-position: center;">
                    </div>
                    <div class="col-md-7 col-sm-12">
                        <div class="row py-2">
                            {!! \Illuminate\Support\Str::words($courseData->description) !!}
                        </div>
                        <div class="row py-4 bg-secondary text-white meta-details">
                            <div class="col-6">
                                Fee Detail: {{$courseData->fee_details}}
                            </div>
                            <div class="col-6">
                                Course Length: {{$courseData->course_length}}
                            </div>
                        </div>
                        <div class="row py-4 bg-secondary text-white meta-details">
                            <div class="col-6">
                                Area: {{$courseData->study_area}}
                            </div>
                            <div class="col-6">
                                Campus: {{$courseData->campus}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Assessment Section        --}}
        <h2 class="m-2 mb-0 d-flex justify-content-between">
            <span>Assessments</span>
            <a href="{{route('admin.courses.assessments.create',['course'=> $courseData->slug])}}"
               class="btn btn-primary">Add New
                Assessment</a>
        </h2>

        <div class="w-100 h-100 bg-white mx-2 p-2">
            <table class="table table-striped table-bordered" style="font-size: small;">
                <thead>
                <tr>
                    <th class="text-center" style="width: 2%;">#</th>
                    <th class="text-center" style="width: 5%;">Name</th>
                    <th class="text-center" style="width: 10%;">Description</th>
                    <th class="text-center" style="width: 10%;">Material</th>
                    <th class="text-center" style="width: 15%;">Created At</th>
                    <th class="text-center" style="width: 10%;">Action</th>
                </tr>
                </thead>
                <tbody>
                @isset($courseData->assessments)
                    @foreach($courseData->assessments as $assessment)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td class="text-center">{{ $assessment->name }}</td>
                            <td class="text-center">{{ \Illuminate\Support\Str::words($assessment->description, 10, '...') }}</td>
                            <td class="text-center">
                                <a href="{{ asset(\App\DTO\Questionnaire\AssessmentData::PUBLIC_PATH.'/'.$assessment->material) }}"
                                   class="btn btn-blueLight" target="_blank">View File</a>
                            </td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($assessment->created_at)->format('d M Y') }}</td>
                            <td class="text-left">
                                @include('questionnaire.common.list-actions',[
                                "iteration"=>$loop->iteration,
                                "createRoute" => ["name"=>"admin.courses.assessments.modules.create", "label"=>"Create Module"],
                                "editRoute" => ["name"=>"admin.courses.assessments.edit","label"=>"Edit"],
                                "deleteRoute"=> ["name"=>"admin.courses.assessments.destroy","label"=>"Delete"],
                                "showRoute"=> ["name"=>"admin.courses.assessments.show","label"=>"Show Detail"],
                                "param" => ["assessment" => $assessment->slug, "course" => $courseData->slug]
                                ])
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center" colspan="5">No Data Found</td>
                    </tr>
                @endisset
                </tbody>
            </table>
        </div>
    </div>
@endsection
