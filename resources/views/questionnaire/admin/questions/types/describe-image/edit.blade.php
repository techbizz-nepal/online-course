<div class="form-group row">
    <div class="col-12">
        <label for="body">Question Text</label>
        <textarea class="form-control @error('body') is-invalid @enderror"
                  name="body"
                  id="body"
                  rows="10">{{$question->body ?? @old('body')}}</textarea>
        @error('body')
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <div class="col-6">
        <label for="image">Question Image</label>
        <div class="input-group">
            <input @readonly(true)
                   class="form-control @error('image_path') is-invalid @enderror"
                   name="image_path"
                   id="image_path"
                   value="{{$question->describeImage->image_path ?? @old('image_path')}}">
            <div class="input-group-append">
                <button id="upload-btn" class="btn btn-primary">Upload</button>
            </div>
        </div>
        <input style="display: none" class="form-control @error('material') is-invalid @enderror"
               type="file"
               name="material" id="material" accept="image/*">
        @error('material')
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
        <div class="progress mt-2">
            <div
                    class="progress-bar"
                    role="progressbar"
                    style="width: 0;"
                    id="upload-progress"
                    aria-valuenow="25"
                    aria-valuemin="0"
                    aria-valuemax="100">0%
            </div>
        </div>
    </div>

</div>
@push('js')
    <script type="text/javascript" src="{{ asset('assets/js/admin-utilities.js') }}"></script>
    <script>
        const requestPath = `{{route('admin.courses.assessments.modules.questions.storeMaterial', [$course, $assessment, $module, 'type' => request()->get('type')])}}`
        const token = `{{csrf_token()}}`
        const fileInputEl = document.getElementById('material')
        const textInputEl = document.getElementById('image_path')
        const uploadBtnEl = document.getElementById('upload-btn')
        const uploadProgressEl = document.getElementById('upload-progress')
        const bodyInputEl = document.getElementById('body')
        const regex = /[A-Za-z0-9_-]+/

        uploadBtnEl.addEventListener('click', (e) => {
            e.preventDefault()
            if (regex.test(bodyInputEl.value)) {
                fileInputEl.click()
            } else {
                bodyInputEl.focus()
            }
        })
        fileInputEl.addEventListener('change', (e) => {
            e.preventDefault()
            const file = fileInputEl.files[0]
            if (file) {
                const body = prepareRequestFormData('image_path', file, bodyInputEl.value)
                postRequestToServer(requestPath, token, body, uploadProgressEl, textInputEl)
            }
        })
    </script>
@endpush
