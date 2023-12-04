<div class="form-group row mx-auto">
    <div class="col-12">
        <label for="body">Question Text</label>
        <textarea class="form-control @error('body') is-invalid @enderror"
                  name="body"
                  id="body">{{@old('body')}}</textarea>
        @error('body')
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>
<div class="form-group row mx-auto">
    <div class="col-12">
        <button class="btn btn-outline-warning mb-2"
                id="add-describe-image-question">
            Add Question
        </button>
    </div>
</div>
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endpush
@push('js')
    <script src="{{asset('assets/js/admin-utilities.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

    <script defer>
        const pageId = getPageId()
        const textArea = document.getElementById('body')
        const addBtnEl = document.getElementById("add-describe-image-question")
        let describeImageQuestionCount = getSessionItem(pageId)

        populateExistingInputBox(describeImageQuestionCount, addBtnEl)

        addBtnEl.addEventListener('click', (event) => {
            event.preventDefault()
            describeImageQuestionCount++
            incrementInputBox(pageId, describeImageQuestionCount, addBtnEl)
            return false
        })
        $("#body").summernote({
            tabsize: 2,
            height: 250
        })
    </script>
@endpush
