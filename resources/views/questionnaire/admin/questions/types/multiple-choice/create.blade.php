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
    @php $id = str()->orderedUuid() @endphp
    <div class="form-group row mx-auto">
        <div class="col-6">
            <input type="hidden" name="choices[{{$loop->index}}][id]" value="{{$id}}" />
            <input name="choices[{{$loop->index}}][value]"
                   type="text" class="form-control mb-2 @error("option".$loop->iteration) is-invalid @enderror"
                   placeholder="choice {{$loop->index}}"
                   value="{{@old("choices[{$loop->index}][value]")}}"
            >
            @error("option".$loop->iteration)
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-6 form-check py-2">
            <input type="checkbox"
                   name="choices[{{$loop->index}}][checked]"
                   class="form-check-input"
                   id="choices{{$loop->iteration}}">
        </div>
    </div>
@endforeach
<input type="hidden" name="answer">
@push('js')
    <script defer src="{{asset('assets/js/admin-utilities.js')}}" ></script>
@endpush

