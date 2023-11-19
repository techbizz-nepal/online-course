<form id="answerForm">
    <div class="w-75 h-100 my-5 mx-5" id="answer-body">
        @if(isset($question->readAndAnswer->questions))
            @foreach($question->readAndAnswer->questions as $item)
                <div class="mb-4">
                    <p class="mb-2">{{$loop->iteration}}. {{$item['value']}}</p>
                    <textarea name="answer['{{$item['id']}}']" class="form-control" rows="3"> </textarea>
                </div>
            @endforeach
        @else
            <p class="text-lg-center">Please contact with Administrator</p>
        @endif
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
    <script src="{{ asset('assets/js/student-utilities.js') }}"></script>
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
        submitAnswerForm.addEventListener('submit', async (e) => {
            e.preventDefault()
            const data = new FormData(e.currentTarget)
            data.append("exam_id", `{{$exam->id}}`)
            data.append("question_id", `{{$question->id}}`)


            let answers = Array.from(data.entries())
                .filter(([key, value]) => key.startsWith('answer[') && value.trim() === '')

            if (answers.length > 0) {
                fireToast('error', 'Please give all answers');
            } else {
                validation = true;
            }

            if (validation) {
                await submitAnswer(answerPostUrl, data, csrfToken, afterSuccessfullyCall)
            }
        })
    </script>
@endpush
