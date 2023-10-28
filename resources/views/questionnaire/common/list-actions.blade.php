@php
    use App\Enums\Questionnaire\QuestionType;
@endphp
@isset($editRoute)
    <a href="{{ route($editRoute["name"], $param) }}"
       class="btn btn-info mb-1">{{$editRoute["label"]}}</a>
@endif
@isset($deleteRoute)
    <a href="javascript:void(0)"
       onclick="document.getElementById('deleteCourse{{ $iteration }}').submit();"
       class="btn btn-danger mb-1">{{$deleteRoute["label"]}}</a>
    <form
        action="{{ route($deleteRoute["name"], $param) }}"
        class="d-none" method="POST"
        id="deleteCourse{{ $iteration }}">
        @csrf
        @method('DELETE')
    </form>
@endif

@isset($showRoute)
    <a href="{{ route($showRoute["name"], $param) }}"
       class="btn btn-outline-success mb-1">
        {{$showRoute["label"]}}
    </a>
@endif
@if(isset($createRoute) && !isset($createRoute["types"]))
    <a href="{{ route($createRoute["name"], $param) }}"
       class="btn btn-info mb-1">{{ $createRoute["label"] }}
    </a>
@endif
@isset($createRoute["types"])
    <div class="dropdown">
        <button
            class="btn btn-outline-success dropdown-toggle mb-1"
            type="button"
            id="dropdownMenuButton"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false">
            {{$createRoute["label"]}}
        </button>
        <div
            class="dropdown-menu"
            aria-labelledby="dropdownMenuButton">
            @foreach($questionTypes as $questionType)
                <a class="dropdown-item"
                   href="{{route($createRoute["name"], $param+['questionType' => QuestionType::from($questionType["type"])])}}">
                    {{QuestionType::from($questionType["type"])->value()}}
                </a>
            @endforeach
        </div>
    </div>
@endif
