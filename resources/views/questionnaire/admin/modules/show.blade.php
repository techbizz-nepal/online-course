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
            <span class="mr-2 p-2 ">{{$module->name}}</span>
        </h2>
        <div class="w-100 h-100 bg-white mx-2 p-2">
            <div class="container-fluid mx-auto">
                <div class="row">
                    {{--                    <div class="col-md-5 col-sm-12">--}}
                    {{--                        <img--}}
                    {{--                            alt="{{ $module->matrial }}"--}}
                    {{--                            src="{{ asset('storage/images/courses/'.$image) }}"--}}
                    {{--                            class="img-thumbnail"--}}
                    {{--                            style="object-fit: cover; object-position: center;">--}}
                    {{--                    </div>--}}
                    <div class="col-md-7 col-sm-12">
                        <div class="row py-2">
                            {!! $module->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Module Section        --}}
        <div class="m-2 mb-0 d-flex justify-content-between">
            <h2>
                <span>Questions</span>
            </h2>
            <div class="dropdown">
                <button
                    class="btn btn-primary dropdown-toggle mb-1"
                    type="button"
                    id="dropdownMenuButton"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false">
                    Create Question
                </button>
                <div
                    class="dropdown-menu"
                    aria-labelledby="dropdownMenuButton">
                    @foreach($questionTypes as $questionType)
                        <a class="dropdown-item"
                           href="{{route("admin.courses.modules.questions.create", ["course" => $course->slug, "module" => $module->slug, 'type'=> $questionType['type']])}}">
                            {{$questionType['label']}}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="h-100 bg-white mx-3 p-2">
            <table class="table table-striped table-bordered table-responsive" style="font-size: small;">
                <thead>
                <tr>
                    <th class="text-center" style="width: 2%;">#</th>
                    <th class="text-center" style="width: 5%;">Text</th>
                    <th class="text-center" style="width: 10%;">Type</th>
                    <th class="text-center" style="width: 15%;">Created At</th>
                    <th class="text-center" style="width: 10%;">Action</th>
                </tr>
                </thead>
                <tbody>
                @isset($module->questions)
                    @foreach($module->questions as $question)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td class="text-center w-25">{!! str()->words($question->body, 20) !!}</td>
                            <td class="text-center w-25">
                                <p>{{ $question->type->value() }}</p>
                                <p>Weight: {{$question->weight}}</p>
                            </td>
                            <td class="text-center w-25">{{ \Carbon\Carbon::parse($question['created_at'])->format('d M Y') }}</td>
                            <td class="text-left w-25">
                                @include('questionnaire.common.list-actions',[
                                "iteration"=>$loop->iteration,
                                "editRoute" => ["name"=>"admin.courses.modules.questions.edit","label"=>"Edit"],
                                "deleteRoute"=> ["name"=>"admin.courses.modules.questions.destroy","label"=>"Delete"],
//                                "showRoute"=> ["name"=>"admin.courses.modules.questions.show","label"=>"Show Detail"],
                                "param" => ["course" => $course->slug, "module" => $module->slug, "question"=>$question->id, "type" => $question->type]
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
