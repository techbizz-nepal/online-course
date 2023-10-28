@isset($options)
    @foreach($options as $option)
        <div class="form-group row">
            <div class="col-6">
                <input name="option1"
                       type="text" class="form-control mb-2 @error('option1') is-invalid @enderror"
                       placeholder="option 1"
                       value="{{$option->getAttribute('body')}}"
                >
                @error('option1')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-6 form-check py-2">
                <input type="radio"
                       name="choose"
                       class="form-check-input"
                       id="option1" @checked($option->getAttribute('is_correct'))>
            </div>
        </div>
    @endforeach
@endif
@push('js')
    <script type="text/javascript" src="{{asset('assets/js/admin-utilities.js')}}" >
@endpush
