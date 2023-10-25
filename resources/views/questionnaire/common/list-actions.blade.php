<a href="{{ route($editRouteName, $param) }}"
   class="btn btn-info mb-1">Edit</a>
<a href="javascript:void(0)"
   onclick="document.getElementById('deleteCourse{{ $iteration }}').submit();"
   class="btn btn-danger mb-1">Delete</a>
<form
    action="{{ route($deleteRouteName, $param) }}"
    class="d-none" method="POST"
    id="deleteCourse{{ $iteration }}">
    @csrf
    @method('DELETE')
</form>
<a href="{{ route($showRouteName, $param) }}"
   class="btn btn-info mb-1">View
    Detail</a>
