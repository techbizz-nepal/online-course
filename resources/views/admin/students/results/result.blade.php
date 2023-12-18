@extends('admin.layout.app')
@section('student', 'active')
@section('content')
    <div class="main-content pt-lg-4">
        <h2 class="m-2 mb-0 d-flex justify-content-evenly">
            <a href="{{route('admin.student.exams', [$exam['student_id']])}}"
               class="mr-2 py-2 px-4 bg-primary rounded text-white">
                <i class="fas fa-arrow-left"></i>
            </a>
            <span class="mr-2 p-2">Answers submitted for {{str()->title($exam['module']['name'])}} Module</span>
        </h2>
        <div class="w-100 h-100 bg-white mx-2 p-2">
            @isset($exam->examQuestion)
                @foreach($exam->examQuestion as $question)
                    <x-questionnaire.admin.answered-question :$question>
                        <x-questionnaire.admin.answered-type :$question>
                            <div class="my-3 col-6">
                                <label for="weight">Score</label>
                                <input class="form-control col-4 mb-2" type="number" name="score" id="score"
                                       value="{{$question->pivot->score}}"
                                       max="{{$question->weight}}">
                                <button type="button"
                                        class="btn btn-success"
                                        submission-url="{{route("admin.student.examQuestion.marking", [$question->pivot->id])}}"
                                        onclick="submitAnswerWeight(this)">Submit
                                </button>
                            </div>
                        </x-questionnaire.admin.answered-type>
                    </x-questionnaire.admin.answered-question>
                @endforeach
            @endisset

        </div>
    </div>
@endsection
@push('js')
    <script defer src="{{ asset('assets/js/student-utilities.js') }}"></script>
    <script>
        const submitAnswerWeight = (element) => {
            const answerInputEl = element.previousElementSibling
            const answerWeightVal = answerInputEl.value

            if (parseInt(answerWeightVal) > parseInt(answerInputEl.max)) fireToast('error', 'Answer weight cannot be greater that Question weight')

            // compose server data
            const tokenVal = `{{csrf_token()}}`
            const url = element.getAttribute('submission-url')
            const formData = new FormData()
            formData.set('score', answerWeightVal)

            disableEls([element, answerInputEl])
            const successCall = (data) => {
                disableEls([element, answerInputEl], false)
                fireToast('success', 'Score submitted')
            }
            postAnswerWeight(url, formData, tokenVal, successCall)

            return false
        }

        const postAnswerWeight = async (postUrl, dataObj, token, callable) => {
            return await fetch(postUrl, {
                method: "POST",
                body: dataObj,
                headers: {
                    "X-CSRF-TOKEN": token,
                    "Accept": "application/json"
                },
                mode: "same-origin",
                credentials: "same-origin"
            })
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    }
                    throw new Error(response.statusText);
                })
                .then(callable)
        }
        const disableEls = (elements, flag = true) => {
            if (Array.isArray(elements)) {
                elements.forEach(element => {
                    flag ? element.setAttribute('disabled', "true") : element.removeAttribute('disabled')
                })
            } else {
                flag ? elements.setAttribute('disabled', "true") : elements.removeAttribute('disabled')
            }
        }
    </script>
@endpush
