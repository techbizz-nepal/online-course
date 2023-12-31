<div class="form-group row mx-auto">
    <div class="col-9">
        <label for="body">Question Text</label>
        <textarea class="form-control @error('body') is-invalid @enderror"
                  name="body"
                  id="body"
                  rows="2">{{@old('body')}}</textarea>
        @error('body')
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    {{$slot}}
</div>
@foreach(range(0, 3) as $option)
    <div class="form-group row mx-auto">
        <div class="col-6">
            <input name="option{{$loop->iteration}}"
                   type="text" class="form-control mb-2 @error("option".$loop->iteration) is-invalid @enderror"
                   placeholder="option {{$loop->iteration}}"
                   value="{{@old("option".$loop->iteration)}}"
            >
            @error("option".$loop->iteration)
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-6 form-check py-2">
            <input type="radio"
                   name="choose"
                   class="form-check-input"
                   id="option{{$loop->iteration}}" @checked($loop->iteration == 1)>
        </div>
    </div>
@endforeach
<input type="hidden" name="answer">
@push('js')
    <script defer src="{{asset('assets/js/admin-utilities.js')}}" ></script>
@endpush
