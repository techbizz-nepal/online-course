<div class="form-group row mx-auto">
    <div class="col-9">
        <label for="body">Question Text</label>
        <textarea class="form-control @error('body') is-invalid @enderror"
                  name="body"
                  id="body"
                  rows="2">{{$question->body ?? @old('body')}}</textarea>
        @error('body')
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    {{$slot}}
</div>
@isset($question->multipleChoice)
    @foreach($question->multipleChoice->body as $choice)
{{--        @dd([$key, $value])--}}
        <div class="form-group row mx-auto">
            <div class="col-6">
                <input type="hidden" name="choices[{{$loop->index}}][id]" value="{{$choice['id']}}" />
                <input name="choices[{{$loop->index}}][value]"
                       type="text" class="form-control mb-2 @error("option".$loop->iteration) is-invalid @enderror"
                       placeholder="choice {{$loop->index}}"
                       value="{{$choice['value']}}"
                >
                @error("option".$loop->iteration)
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-6 form-check py-2">
                <input type="checkbox"
                       name="choices[{{$loop->index}}][checked]"
                       class="form-check-input"
                       @checked(array_key_exists('checked', $choice) && $choice['checked'] == 'on')
                       id="choices{{$loop->iteration}}">
            </div>
        </div>
    @endforeach
@endif
@push('js')
    <script defer src="{{asset('assets/js/admin-utilities.js')}}" ></script>
@endpush

