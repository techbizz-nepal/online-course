<div class="form-group {{$cols}}">
    <label for="title">{{$label}}</label>
    <select id="{{$id}}" class="form-select form-control" name="{{$name}}"
    >
        @isset($options)
            @foreach($options as $option)
                <option @selected($option['value'] == $value) value="{{$option['value']}}">
                    {{$option['label']}}
                </option>
            @endforeach
        @endif
    </select>
</div>
