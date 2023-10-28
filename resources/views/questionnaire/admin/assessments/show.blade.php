@extends('admin.layout.app')
@section('courses', 'active')
@section('content')
    <div class="main-content pt-lg-4">
        <h2 class="m-2 mb-0 d-flex justify-content-evenly">
            <a
                href="{{route("admin.courses.show", ['course'=> $course->slug])}}"
                class="mr-2 py-2 px-4 bg-primary rounded text-white">
                <i class="fas fa-arrow-left"></i>
            </a>
            <span class="mr-2 p-2 ">{{$assessment->name}}</span>
        </h2>
        <div class="w-100 h-100 bg-white mx-2 p-2">
            <div class="container-fluid">
                <div class="row">
                    {{--                    <div class="col-md-5 col-sm-12">--}}
                    {{--                        <img--}}
                    {{--                            alt="{{ $assessment->matrial }}"--}}
                    {{--                            src="{{ asset('storage/images/courses/'.$image) }}"--}}
                    {{--                            class="img-thumbnail"--}}
                    {{--                            style="object-fit: cover; object-position: center;">--}}
                    {{--                    </div>--}}
                    <div class="col-md-7 col-sm-12">
                        <div class="row py-2">
                            {!! \Illuminate\Support\Str::words($assessment->description) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Module Section        --}}
        <h2 class="m-2 mb-0 d-flex justify-content-between">
            <span>Modules</span>
            <a href="{{route('admin.courses.assessments.modules.create',['course'=> $course->slug, 'assessment' => $assessment->slug])}}"
               class="btn btn-primary">
                Add New Module
            </a>
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
                @isset($assessment->modules)
                    @foreach($assessment->modules as $module)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td class="text-center">{{ $module->name }}</td>
                            <td class="text-center">{{ \Illuminate\Support\Str::words($module->description, 10, '...') }}</td>
                            <td class="text-center">
                                <a href="{{ asset(\App\DTO\Questionnaire\ModuleData::PUBLIC_PATH.'/'.$module['material']) }}"
                                   class="btn btn-blueLight" target="_blank">View File</a>
                            </td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($module['created_at'])->format('d M Y') }}</td>
                            <td class="text-left">
                                @include('questionnaire.common.list-actions',[
                                "iteration"=>$loop->iteration,
                                "createRoute" => ["name"=>"admin.courses.assessments.modules.questions.create", "label"=>"Create Question", "types" => $questionTypes],
                                "editRoute" => ["name"=>"admin.courses.assessments.modules.edit","label"=>"Edit"],
                                "deleteRoute"=> ["name"=>"admin.courses.assessments.modules.destroy","label"=>"Delete"],
                                "showRoute"=> ["name"=>"admin.courses.assessments.modules.show","label"=>"Show Detail"],
                                "param" => ["assessment" => $assessment->slug, "course" => $course->slug, "module" => $module->slug]
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
