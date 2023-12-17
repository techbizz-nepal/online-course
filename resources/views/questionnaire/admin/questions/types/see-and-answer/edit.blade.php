<div class="form-group row mx-auto">
    <div class="col-9">
        <label for="body">Question Text</label>
        <input class="form-control @error('body') is-invalid @enderror"
               value="{{$question->body ?? @old('body')}}"
               name="body"
               id="body"
               minlength="5"
                @required(true)
        />
        @error('body')
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    {{$slot}}
</div>

<div class="form-group row">
    @isset($question->seeAndAnswer->items)
        @foreach($question->seeAndAnswer->items as $key => $item)
            <div class="mx-auto col-12 col-md-3 mb-3 p-3 border border-1 border-info">
                <div id="correctAnsDiv" class="mb-4">
                    <input type="hidden" name="items[{{$key}}][id]"
                           value="{{$item['id'] ?? @old("items[$key][id]") ?? \Illuminate\Support\Str::orderedUuid()}}">
                    <input class="form-control imageName" type="text" name="items[{{$key}}][name]"
                           value="{{$item['name'] ?? @old("items[$key][name]")}}"
                           @required(true) placeholder="Image Name"/>
                </div>
                <div id="fileUploadDiv">
                    <label for="image_path">Image</label>
                    <div id="filePathInput" class="input-group">
                        <input @readonly(true)
                               @required(true)
                               class="form-control image_path @error('image_path') is-invalid @enderror"
                               name="items[{{$key}}][image_path]"
                               id="image_path"
                               type="text"
                               value="{{$item['image_path'] ?? @old('image_path')}}">
                        <div class="input-group-append">
                            <button id="upload-btn-{{$key}}" class="btn btn-primary upload-btn">Upload</button>
                        </div>
                    </div>

                    <input style="display: none"
                           class="image_file form-control @error('image_file') is-invalid @enderror"
                           type="file"
                           name="items[{{$key}}][image_file]"
                           id="image_file_{{$key}}"
                           accept="image/*">
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
                    <div class="position-relative pt-2 preview">
                        <img src="{{asset(sprintf("%s/%s", \App\DTO\Questionnaire\QuestionSeeAndAnswerData::PUBLIC_PATH, $item['image_path']))}}"
                             alt="{{$item['name']}}">
                    </div>
                </div>
            </div>
        @endforeach
    @endisset
</div>
@push('js')
    <script type="text/javascript" src="{{ asset('assets/js/admin-utilities.js') }}"></script>
    <script>
        const requestPath = `{{route('admin.modules.questions.updateImage', [$module, $question, 'type' => request()->get('type')])}}`
        const token = `{{csrf_token()}}`
        const bodyInputEl = document.getElementById('body')
        const uploadBtnArray = document.getElementsByClassName('upload-btn')
        const imageNameArray = document.getElementsByClassName('imageName')
        const fileInputArray = document.getElementsByClassName('image_file')
        const textInputArray = document.getElementsByClassName('image_path')
        const uploadProgressElArray = document.getElementsByClassName('progress-bar')
        const previewElArray = document.getElementsByClassName('preview')
        const regex = /[A-Za-z0-9_-]+/

        Array.from(uploadBtnArray).forEach((button, index) => {
            button.addEventListener("click", (e) => {
                e.preventDefault()
                if (regex.test(imageNameArray[index].value)) {
                    fileInputArray[index].click()
                    previewElArray[index].remove()
                } else {
                    imageNameArray[index].focus()
                }
            })
            fileInputArray[index].addEventListener('change', (e) => {
                e.preventDefault()
                const file = fileInputArray[index].files[0]
                if (file) {
                    const body = prepareRequestFormData('image_path', file, bodyInputEl.value)
                    postRequestToServer(requestPath, token, body, uploadProgressElArray[index], textInputArray[index])
                }
            })
        })
    </script>
@endpush
