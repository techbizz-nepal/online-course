<div class="form-group {{$cols}}">
    <label for="{{$id}}">{{$label}}</label>
    <input @required($required)
           class="form-control mb-2"
           id="{{$id}}"
           type="{{$type}}"
           name="{{$name}}"
           placeholder="{{$placeholder}}"
           value="{{$value ?? old($name)}}"
           @readonly($readonly)
           @if($pattern) pattern="{{$pattern}}" @endif
    />
    @if($helpText !== '')
        <span>
            @if($helpLink !== "#")
                <a target="_blank" href="{{$helpLink}}">{{$helpText}}</a>
            @else
                {{$helpText}}
            @endif
        </span>
    @endif
</div>
