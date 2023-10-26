<a href="{{ route($createRoute["name"], $param) }}"
   class="btn btn-info mb-1">{{ $createRoute["label"] }}</a>
<a href="{{ route($editRoute["name"], $param) }}"
   class="btn btn-info mb-1">{{$editRoute["label"]}}</a>
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
<a href="{{ route($showRoute["name"], $param) }}"
   class="btn btn-info mb-1">{{$showRoute["label"]}}</a>
