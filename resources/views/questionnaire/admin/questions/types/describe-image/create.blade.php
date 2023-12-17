<div class="form-group row mx-auto">
    <div class="col-12">
        <label for="body">Question Text</label>
        <input class="form-control @error('body') is-invalid @enderror"
               name="body"
               id="body"
               value="{{@old('body') ?? "Observe the image and answer the questions"}}"/>
        @error('body')
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>
<div class="form-group row mx-auto">
    <div class="col-6">
        <label for="image">Question Image</label>
        <div class="input-group">
            <input @readonly(true)
                   class="form-control @error('image_path') is-invalid @enderror"
                   name="image_path"
                   id="image_path"
                   type="text"
                   value="{{@old('image_path')}}">

            <div class="input-group-append">
                <button id="upload-btn" class="btn btn-primary">Upload</button>
            </div>
        </div>

        <input style="display: none" class="form-control @error('image_file') is-invalid @enderror"
               type="file"
               name="image_file" id="image_file" accept="image/*">
        @error('image_file')
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
<div class="form-group row mx-auto">
    <div class="col-12" id="question-wrapper">
        <p class="btn btn-outline-warning mb-2"
           onclick="appendInputBox(this)"
           id="add-describe-image-question">
            Add Question
        </p>
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

@push('js')
    <script type="text/javascript" src="{{ asset('assets/js/admin-utilities.js') }}"></script>
    <script>


        const requestPath = `{{route('admin.modules.questions.uploadImage', [$module, 'type' => request()->get('type')])}}`
        const token = `{{csrf_token()}}`
        const fileInputEl = document.getElementById('image_file')
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
