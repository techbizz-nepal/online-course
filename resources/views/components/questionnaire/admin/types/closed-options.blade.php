@isset($question->option?->body)
    <div class="row">
        <div class="col-8">
            <p> 1. {{$question->option->body['option1']}}</p>
            <p> 2. {{$question->option->body['option2']}}</p>
            <p> 3. {{$question->option->body['option3']}}</p>
            <p> 4. {{$question->option->body['option4']}}</p>
        </div>
    </div>
@endisset
<div class="row">
    <div class="col-3">
        <p class="my-3">Correct Answer: {{$question->option->answer}}</p>
        <p class="my-3">Student Answer: {{ $getClosedOptionAnswer }}</p>
    </div>
</div>
<div class="row">
    {{$slot}}
</div>
