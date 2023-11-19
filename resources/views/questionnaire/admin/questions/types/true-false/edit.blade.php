<div class="form-group row">
    <div class="col-12">
        <label for="body">Question Text</label>
        <input class="form-control @error('body') is-invalid @enderror"
               value="{{$question->body ?? @old('body')}}"
               name="body"
               id="body"
        />
        @error('body')
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <div class="col-2">
        Correct Answer:
    </div>
    <div class="col-10">
        <select class="form-select form-select-lg "
                name="answer"
                aria-label="Correct Answer">
            <option value="1" {{$question->trueFalse?->answer == 1 ? "selected" : ""}}>True</option>
            <option value="0" {{$question->trueFalse?->answer == 0 ? "selected" : ""}}>False</option>
        </select>
    </div>
</div>
