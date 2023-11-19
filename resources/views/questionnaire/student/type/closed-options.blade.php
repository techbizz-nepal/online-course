@php
    use App\Enums\Questionnaire\ColorType;use Illuminate\Support\Arr;
@endphp
<form id="answerForm">
    <div class="w-75 h-100 my-5 mx-5" id="answer-body">
        @isset($question->option)
            @foreach($question->option->body as $key => $value)
                <div class="mb-3 py-2 inline options cursor-pointer bg-white" id="{{$key}}"
                     onclick="handleOptionClick(this)">
                <span
                    class="mx-2 p-2 tb-bg-{{$loop->iteration}} text-white">{{str()->title($loop->iteration)}}</span>
                    <span>{{$value}}</span>
                </div>
            @endforeach

        @else
            <p class="text-lg-center">Please contact with Administrator</p>
        @endif
        <input type="hidden" value="" name="answer" id="answer"/>
    </div>
    <div class="w-100 h-100 mx-2 px-4 py-2 text-right" style="background-color: #f5f5f4">
        <button class="btn btn-success"
                onclick="handleBackToModuleIndex(this, `{{route('student.moduleStart', [$course, $assessment, $module])}}`);return false">
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
        const submitAnswerForm = document.getElementById('answerForm')
        const backBtnEl = document.getElementById('back-to-index')
        const trueFalseAnswer = document.getElementById('answer')
        const listLocation = `{{route('student.moduleStart', [$course, $assessment, $module])}}`
        const answerPostUrl = `{{route('student.submitAnswer', [$course, $assessment, $module, $question, $exam])}}`
        const csrfToken = `{{csrf_token()}}`

        const afterSuccessfullyCall = (data) => {
            if (data.result) {
                fireToast('success', 'Your answer is correct')
            } else {
                fireToast('error', 'Your answer is incorrect')
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
            const data = new FormData(e.currentTarget)
            data.append("exam_id", `{{$exam->id}}`)
            data.append("question_id", `{{$question->id}}`)
            for (const key of data.keys()) {
                !data.get('answer')?.length
                    ? fireToast('error', 'Please give answer')
                    : validation = true
            }
            if (validation) {
                submitAnswer(answerPostUrl, data, csrfToken, afterSuccessfullyCall)
            }
        })
    </script>
@endpush
