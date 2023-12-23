<form id="answerForm">
    <div class="row my-5 mx-5" id="answer-body">
        @isset($question->seeAndAnswer->items)
            @foreach($question->seeAndAnswer->items as $key => $value)
                <div class="mx-auto col-3 mb-3 p-3 border border-1 border-info">
                    <div id="correctAnsDiv" class="mb-4">
                        <input type="hidden" name="answer[{{$key}}][id]"
                               value="{{$value['id']}}">
                        <input class="form-control imageName" type="text" name="answer[{{$key}}][name]"
                               @required(true) placeholder="Give image Name"/>
                    </div>
                    <div class="position-relative pt-2 preview">
                        <img src="{{asset(sprintf("%s/%s", \App\DTO\Questionnaire\QuestionSeeAndAnswerData::PUBLIC_PATH, $value['image_path']))}}"
                             alt="{{$value['name']}}">
                    </div>
                </div>
            @endforeach
        @else
            <p class="text-lg-center">Please contact with Administrator</p>
        @endif
    </div>
    <div class="w-100 h-100 mx-2 px-4 py-2 text-right" style="background-color: #f5f5f4">
        <button class="btn btn-success"
                onclick="handleBackToModuleIndex(this, `{{route('student.moduleStart', [$course, $module])}}`);return false">
            Back
        </button>
        <button type="submit" class="btn btn-success">Submit answer</button>
    </div>
</form>
@push('js')
    <script defer src="{{ asset('assets/js/student-utilities.js') }}"></script>
    <script>
        let validation = false
        const submitAnswerForm = document.getElementById('answerForm')
        const describeImageAnswer = document.getElementById('answer')
        const answerPostUrl = `{{route('student.submitAnswer', [$course, $module, $question, $exam])}}`
        const csrfToken = `{{csrf_token()}}`
        const listLocation = `{{route('student.moduleStart', [$course, $module])}}`

        const afterSuccessfullyCall = (data) => {
            console.log(data)
            if (data.result) {
                fireToast('success', data.msg)
            } else {
                fireToast('error', data.msg)
            }
            if (data.nextQuestion) {
                setTimeout(() => {
                    window.location = data.nextQuestion
                }, 2000)
            } else {
                setTimeout(() => {
                    window.location = listLocation
                }, 2000)
            }
        }
        submitAnswerForm.addEventListener('submit', async(e) => {
            e.preventDefault()
            const data = new FormData(e.currentTarget)
            data.append("exam_id", `{{$exam->id}}`)
            data.append("question_id", `{{$question->id}}`)
            // for (const key of data.keys()) {
            //     !data.get('answer')?.length
            //         ? fireToast('error', 'Please give answer')
            //         : validation = true
            // }
            await submitAnswer(answerPostUrl, data, csrfToken, afterSuccessfullyCall)
            if (validation) {

            }
        })

    </script>
@endpush
