@extends('admin.layout.app')
@section('content')
    <div class="main-content pt-lg-4">
        <h2 class="m-2 mb-0 d-flex justify-content-between ">
            <span>Detail of {{$student['fullName']}}</span>
        </h2>

        <div class="w-100 h-100 bg-white mx-1 p-2">
            <div class="row mb-3">
                @foreach($student as $key => $value)
                    <div class="col-3 mb-2">
                        <p class="font-weight-bold">{{str($key)->replace('_', ' ')->title()}}: <span
                                class="font-weight-normal">{{$value ? str($value)->title() : 'N/A'}}</span></p>
                    </div>
                @endforeach
            </div>
            <div class="row mb-3">
                <div class="col-12" id="heading">
                    <h4 class="mb-4 bg-flat-color-1 p-3 text-white">
                        Survey
                    </h4>
                </div>

                @foreach($survey as $key => $category)
                                    @dump($category)
                    <div class="col-3 mb-2">
                        <p class="font-weight-bold mb-2">{{str($key)->replace('_', ' ')->title()}}</p>
                        @if(!is_array($category))
                            <span
                                class="font-weight-normal ">{{$category ? str($category)->title() : 'N/A'}}</span>
                        @else
                            @foreach($category as $categoryKey => $categoryQuestion)
                                <div class="row col-12 mb-1">
                                    <p>{{$categoryQuestion['label']?? null}} </p>
                                </div>
                                <div class="row col-12 mb-3 font-italic pl-5">
                                    <p>{{$categoryQuestion['value'] ?? null}}</p>
                                </div>
                            @endforeach
                        @endif

                    </div>
                @endforeach
            </div>

        </div>
@endsection
