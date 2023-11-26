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
        <button class="btn btn-outline-warning mb-2"
                id="add-describe-image-question">
            Add Question
        </button>
    </div>
</div>
@push('js')
    <script src="{{asset('assets/js/admin-utilities.js')}}"></script>
    <script defer>
        const pageId = getPageId()
        const addBtnEl = document.getElementById("add-describe-image-question")
        let describeImageQuestionCount = getSessionItem(pageId)

        populateExistingInputBox(describeImageQuestionCount, addBtnEl)

        addBtnEl.addEventListener('click', (event) => {
            event.preventDefault()
            describeImageQuestionCount++
            incrementInputBox(pageId, describeImageQuestionCount, addBtnEl)
            return false
        })
    </script>
@endpush
