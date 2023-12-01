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
    <div class="col-12">
        <button class="btn btn-outline-warning mb-2" id="add-describe-image-question">Add Question</button>
        @if(isset($question->readAndAnswer->questions))
            @foreach($question->readAndAnswer->questions as $item)
                <div class="form-group row" id="row-{{$loop->iteration}}">
                    <div class="col-10">
                        <input name="questions['{{$item['id']}}']"
                               value="{{$item['value']}}"
                               type="text"
                               class="form-control mb-2"
                               placeholder="Write question 1"
                               id="questions{{$loop->iteration}}">
                    </div>
                    <div class="col-2 ">
                        <button class="btn btn-danger"
                                id="btn-{{$loop->iteration}}"
                                onclick="deleteRow(this, 'readAndAnswerQuestionUpdate', {{$loop->iteration}})"
                                type="button">Remove Question
                        </button>
                    </div>
                </div>
            @endforeach
        @endif

    </div>
</div>
@push('js')
    <script src="{{asset('assets/js/admin-utilities.js')}}"></script>
    <script>
        const pageId = getPageId('readAndAnswerQuestionUpdate')
        const addBtnEl = document.getElementById("add-describe-image-question")
        const questions = document.getElementsByName('questions[]')
        let describeImageQuestionCount = questions.length

        addBtnEl.addEventListener('click', (event) => {
            event.preventDefault()
            describeImageQuestionCount++
            incrementInputBox(pageId, describeImageQuestionCount, addBtnEl)
            return false
        })
    </script>
@endpush
