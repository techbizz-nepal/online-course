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
    <div class="col-6">
        <label for="image">Question Image</label>
        <div class="input-group">
            <input @readonly(true)
                   class="form-control @error('material') is-invalid @enderror"
                   name="material"
                   id="material"

                   value="{{@old('material')}}">
            <div class="input-group-append">
                <button id="upload-btn" class="btn btn-primary">Upload</button>
            </div>
        </div>
        <input style="display: none" class="form-control @error('upload_material') is-invalid @enderror"
               type="file"
               name="image_path" id="image_path" accept="image/*">
        @error('image_path')
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
        const requestPath = `{{route('admin.courses.assessments.modules.questions.storeMaterial', [$course, $assessment, $module])}}`
        const token = `{{csrf_token()}}`
        const fileInputEl = document.getElementById('image_path')
        const textInputEl = document.getElementById('material')
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
