<form id="answerForm">
    <div class="w-75 h-100 my-5 mx-5" id="answer-body">
        <img alt="{{$question->id}}"
             src="{{asset(sprintf("%s/%s", \App\DTO\Questionnaire\QuestionDescribeImageData::PUBLIC_PATH, $question->describeImage?->image_path))}}"/>
    </div>
    <div class="w-75 h-100 my-5 mx-5" id="answer-body">
        <textarea class="form-control" rows="10" cols="50" name="answer"></textarea>
    </div>
    <div class="w-100 h-100 mx-2 px-4 py-2 text-right" style="background-color: #f5f5f4">
        <button class="btn btn-success"
                onclick="handleBackToModuleIndex(this, `{{route('student.moduleStart', [$course, $assessment, $module])}}`);return false">
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
        const answerPostUrl = `{{route('student.submitAnswer', [$course, $assessment, $module, $question, $exam])}}`
        const csrfToken = `{{csrf_token()}}`
        const listLocation = `{{route('student.moduleStart', [$course, $assessment, $module])}}`

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
            for (const key of data.keys()) {
                !data.get('answer')?.length
                    ? fireToast('error', 'Please give answer')
                    : validation = true
            }
            if (validation) {
                await submitAnswer(answerPostUrl, data, csrfToken, afterSuccessfullyCall)
            }
        })

    </script>
@endpush
