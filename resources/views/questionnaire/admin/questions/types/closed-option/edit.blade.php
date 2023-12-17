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
@isset($question->option)
    @foreach($question->option->body as $key => $value)
        <div class="form-group row mx-auto">
            <div class="col-6">
                <input name="{{$key}}"
                       type="text" class="form-control mb-2 @error($key) is-invalid @enderror"
                       placeholder="{{$key}}"
                       value="{{$value}}"
                >
                @error($key)
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-6 form-check py-2">
                <input type="radio"
                       name="choose"
                       class="form-check-input"
                       id="{{$key}}" @checked($key === $question->option->answer)>
            </div>
        </div>
    @endforeach
    <input type="hidden" name="answer">
@endif
@push('js')
    <script defer src="{{asset('assets/js/admin-utilities.js')}}" ></script>
@endpush
