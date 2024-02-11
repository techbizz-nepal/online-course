<form id="choicesForm">
    <div class="w-75 h-100 my-5 mx-5" id="choices-body">
        @isset($question->multipleChoice)
            @foreach($question->multipleChoice->body as $choice)
                <div class="mb-3 py-2 inline options cursor-pointer bg-white"
                     id="choice{{$loop->iteration}}"
                     onclick="handleChoiceClick(this)"
                     data-id="{{$choice['id']}}"
                     data-color="tb-bg-{{$loop->iteration}}-clicked"
                >
                    <span
                        class="mx-2 p-2 tb-bg-{{$loop->iteration}} text-white">{{str($loop->iteration)->title()}}</span>

                    <span>{{$choice['value']}}</span>
                </div>
            @endforeach
        @else
            <p class="text-lg-center">Please contact with Administrator</p>
        @endif
        <input type="hidden" value="" name="choices" id="choices"/>
    </div>
    <div class="w-100 h-100 mx-2 px-4 py-2 text-right" style="background-color: #f5f5f4">
        <button class="btn btn-success"
                onclick="handleBackToModuleIndex(this, `{{route('student.moduleStart', [$course, $module])}}`);return false">
            Back
        </button>
        <button type="submit" class="btn btn-success">Submit answer</button>
    </div>
</form>
@push('css')
    <link rel="stylesheet" href="{{asset('assets/css/techbizz.css')}}">
@endpush
@push('js')
    <script defer src="{{ asset('assets/js/student-utilities.js') }}"></script>
    <script>
        let validation = false
        const submitAnswerForm = document.getElementById('choicesForm')
        const backBtnEl = document.getElementById('back-to-index')
        const listLocation = `{{route('student.moduleStart', [$course, $module])}}`
        const answerPostUrl = `{{route('student.submitAnswer', [$course, $module, $question, $exam])}}`
        const csrfToken = `{{csrf_token()}}`

        const afterSuccessfullyCall = (data) => {
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
        submitAnswerForm.addEventListener('submit', (e) => {
            e.preventDefault()
            const choices = document.getElementById('choices').value.split(",").filter(choice => choice !== '')
            const data = new FormData(e.currentTarget)
            data.append("exam_id", `{{$exam->id}}`)
            data.append("question_id", `{{$question->id}}`)
            data.append("answer", JSON.stringify(choices))
            for (const key of data.keys()) {
                !data.get('answer')?.length
                    ? fireToast('error', 'Please give answer')
                    : validation = true
            }
            if (validation) {
                data.delete('choices')
                submitAnswer(answerPostUrl, data, csrfToken, afterSuccessfullyCall)
            }
        })
    </script>
@endpush
