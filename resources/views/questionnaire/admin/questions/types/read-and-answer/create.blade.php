<div class="form-group row">
    <div class="col-12">
        <label for="body">Question Text</label>
        <textarea class="form-control @error('body') is-invalid @enderror"
                  name="body"
                  id="body"
                  rows="20">{{@old('body')}}</textarea>
        @error('body')
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <div class="col-12">
        <button class="btn btn-outline-warning mb-2" id="add-question">Add Question</button>
    </div>
</div>
@push('js')
    <script defer src="{{asset('assets/js/admin-utilities.js')}}"></script>
@endpush
