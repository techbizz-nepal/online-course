<div class="form-group {{$cols}}">
    <label for="{{$id}}">{{$label}}</label>
    <input @required($required)
           class="form-control"
           id="{{$id}}"
           type="{{$type}}"
           name="{{$name}}"
           placeholder="{{$placeholder}}"
           value="{{$value ?? old($name)}}"
           @readonly($readonly)
           @if($pattern) pattern="{{$pattern}}" @endif
    />
</div>
