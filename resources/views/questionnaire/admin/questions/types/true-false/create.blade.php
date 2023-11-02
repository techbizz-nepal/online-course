<div class="form-group row">
    <div class="col-12">
        <label for="body">Question Text</label>
        <textarea class="form-control @error('body') is-invalid @enderror"
                  name="body"
                  id="body"
                  rows="2">{{@old('body')}}</textarea>
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
                name="is_true"
                aria-label="Correct Answer">
            <option value="1" selected>True</option>
            <option value="0">False</option>
        </select>
    </div>
</div>
