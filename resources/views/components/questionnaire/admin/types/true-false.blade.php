@isset($question->trueFalse)
    <div class="row">
        <div class="col-3">
            <p class="my-3">Correct Answer: {{$question->trueFalse->answer ? 'True' : 'False'}}</p>
            <p  class="my-3">Student Answer: {{ $getTrueFalseAnswer }}
            </p>

        </div>
    </div>
@endisset
<div class="row">
    {{$slot}}
</div>
