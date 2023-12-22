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
                @foreach($survey as $key => $category)
                    <div class="col-3 mb-2">
                        <p class="font-weight-bold mb-2 bg-flat-color-4 pl-2 text-white">{{str($key)->replace('_', ' ')->title()}}</p>
                        @if(!is_array($category))
                            <span class="font-weight-normal ">{{$category ? str($category)->title() : 'N/A'}}</span>
                        @else
                            @foreach($category as $categoryKey => $categoryQuestion)
                                @if($categoryKey == "education_achievement")
                                    <p class="mb-3">{{$categoryQuestion['label']}}</p>
                                    @foreach($categoryQuestion['level'] as $key => $value)
                                        <p>{{str($key)->replace('_', ' ')->title()->replace('i', 'I')}}: {{str($value['value'])->title()}}</p>
                                    @endforeach
                                @endif
                                @if($key == 'disabilities' && $categoryQuestion != null)
                                    <p class="font-italic pl-3">{{str($categoryQuestion)?->replace('-', ' ')->start('- ')}}</p>
                                @endif
                                @if(isset($categoryQuestion['value']))
                                    @if($categoryQuestion['value'] == 'other')
                                        @continue(true)
                                    @endif
                                    <div class="row col-12 mb-1">
                                        <p>{{$categoryQuestion['label']?? null}} </p>
                                    </div>
                                    <div class="row col-12 mb-3 font-italic pl-3">
                                        <p>{{str($categoryQuestion['value'])?->replace('-', ' ')->start('- ')}}</p>
                                    </div>
                                @endif
                            @endforeach
                        @endif

                    </div>
                @endforeach
            </div>

        </div>
@endsection
