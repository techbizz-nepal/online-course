@extends('admin.layout.app')
@section('content')

    <div class="main-content pt-lg-4">
        <h2 class="m-2 mb-0 d-flex justify-content-between">
            <span>Add New Module</span>
        </h2>
        <div class="w-100 h-100 bg-white mx-2 p-2">
            <form action="{{ route('admin.courses.assessments.modules.store', ['course'=>$course->slug, 'assessment' => $assessment->slug]) }}" method="POST"
                  id="moduleForm" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <div class="col-6">
                        <label for="title">Module Name</label>
                        <input required class="form-control @error('name') is-invalid @enderror" type="text" name="name"
                               value="{{@old('name')}}"
                               id="name" placeholder="Module Name">
                        @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="image">Module Material</label>
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
                               name="upload_material" id="upload_material" accept="application/pdf">
                        @error('upload_material')
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
                <div class="form-group row">
                    <div class="col-6">
                        <label for="description">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" name="description"
                                  id="description" rows="1" placeholder="Description">{{@old('description')}}</textarea>
                        @error('description')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-3">
                        <label for="fullMark">Full Mark</label>
                        <input required class="form-control @error('fullMark') is-invalid @enderror" type="number" name="fullMark"
                               value="{{@old('fullMark')}}"
                               id="fullMark">
                    </div>
                    <div class="col-3">
                        <label for="passMark">Pass Mark</label>
                        <input required class="form-control @error('passMark') is-invalid @enderror" type="number" name="passMark"
                               value="{{@old('passMark')}}"
                               id="passMark">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 text-left">
                        <button class="btn btn-primary" type="submit">Save</button>
                        <a href="{{ route('admin.courses.assessments.show', ['course' => $course->slug, 'assessment'=>$assessment->slug]) }}" class="btn btn-primary"
                           type="submit">Back</a>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript" src="{{ URL::asset ('assets/js/admin-utilities.js') }}"></script>
    <script>
        const requestPath = `{{route('admin.courses.assessments.modules.storeMaterial', ["course" => $course, "assessment" => $assessment])}}`
        const token = `{{csrf_token()}}`
        const fileInputEl = document.getElementById('upload_material')
        const textInputEl = document.getElementById('material')
        const uploadBtnEl = document.getElementById('upload-btn')
        const uploadProgressEl = document.getElementById('upload-progress')
        const nameInputEl = document.getElementById('name')
        const regex = /[A-Za-z0-9_-]+/

        uploadBtnEl.addEventListener('click', (e) => {
            e.preventDefault()
            if (regex.test(nameInputEl.value)) {
                fileInputEl.click()
            } else {
                nameInputEl.focus()
            }
        })
        fileInputEl.addEventListener('change', (e) => {
            e.preventDefault()
            const file = fileInputEl.files[0]
            if (file) {
                const body = prepareRequestFormData('pdfFile', file, nameInputEl.value)
                postRequestToServer(requestPath, token, body, uploadProgressEl, textInputEl)
            }
        })
    </script>
@endpush
