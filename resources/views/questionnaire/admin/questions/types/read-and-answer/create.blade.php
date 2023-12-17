<div class="form-group row mx-auto">
    <div class="col-9">
        <label for="body">Question Text</label>
        <textarea class="form-control @error('body') is-invalid @enderror"
                  name="body"
                  id="body">{{@old('body')}}</textarea>
        @error('body')
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    {{$slot}}
</div>
<div class="form-group row mx-auto">
    <div class="col-12" id="question-wrapper">
        <button class="btn btn-outline-warning mb-2"
                onclick="appendInputBox(this)">
            Add Question
        </button>
        <div class="form-group row" id="row-1">
            <div class="col-10">
                <input id="id1" type="hidden" name="questions[0][id]" value="{{\Illuminate\Support\Str::uuid()}}">
                <input name="questions[0][body]" type="text" class="form-control mb-2" placeholder="Write question 1"
                       @required(true) minlength="5"
                       id="questions1">
            </div>
            <div class="col-2" onclick="removeInputBox(this)">
                <button class="btn btn-danger" id="btn-1" type="button">Remove Question</button>
            </div>
        </div>
    </div>
</div>
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endpush
@push('js')
    <script src="{{asset('assets/js/admin-utilities.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

    <script defer>
        $("#body").summernote({
            tabsize: 2,
            height: 250
        })
    </script>
@endpush
