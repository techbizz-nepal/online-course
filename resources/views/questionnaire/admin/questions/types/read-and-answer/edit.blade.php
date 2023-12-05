<div class="form-group row mx-auto">
    <div class="col-12">
        <label for="body">Question Text</label>
        <textarea class="form-control @error('body') is-invalid @enderror"
                  name="body"
                  id="body"
                  rows="20">{{$question->body ?? @old('body')}}</textarea>
        @error('body')
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>
<div class="form-group row mx-auto">
    <div class="col-12" id="question-wrapper">
        <button onclick="appendInputBox(this)" class="btn btn-outline-warning mb-2" id="add-describe-image-question">
            Add Question
        </button>
        @if(isset($question->readAndAnswer->questions))
            @foreach($question->readAndAnswer->questions as $item)
                <div class="form-group row" id="row-{{$loop->iteration}}">
                    <div class="col-10">
                        <input id="id1" type="hidden" name="questions[{{$loop->index}}][id]"
                               @required(true)
                               value="{{$item['id'] ?? \Illuminate\Support\Str::uuid()}}">
                        <input name="questions[{{$loop->index}}][body]"
                               value="{{$item['body']}}"
                               type="text"
                               @required(true) minlength="5" pattern="[a-zA-Z0-9]+"
                               class="form-control mb-2"
                               placeholder="Write question 1"
                               id="questions{{$loop->iteration}}">
                    </div>
                    <div class="col-2 " onclick="removeInputBox(this)">
                        <button class="btn btn-danger"
                                id="btn-{{$loop->index}}"
                                type="button">Remove Question
                        </button>
                    </div>
                </div>
            @endforeach
        @endif

    </div>
</div>
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endpush
@push('js')
    <script src="{{asset('assets/js/admin-utilities.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

    <script>
        $("#body").summernote({
            tabsize: 2,
            height: 250
        })
    </script>
@endpush
