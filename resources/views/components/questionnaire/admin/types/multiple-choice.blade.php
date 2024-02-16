@isset($question->multipleChoice?->body)
    @foreach($question->multipleChoice?->body as $choice)
        <div class="row">
            <div class="col-8 ">
                <p class="p-2 mb-2 w-50 text-white {{isset($choice['checked']) && $choice['checked'] == "on" ? 'bg-success': 'bg-warning'}}">
                    {{$loop->iteration}}. {{$choice['value']}}
                </p>
            </div>
        </div>
    @endforeach
@endisset
<div class="row">
    <div class="col-3">
        <div class="my-3">Student Answer:</div>
        @foreach($getMultipleChoiceAnswer() as $answer)
            <p class="p-2 mb-2 w-50 text-white {{isset($answer['checked']) && $answer['checked'] == "on" ? 'bg-success': 'bg-warning'}}">
                {{$answer['value']}}
            </p>
        @endforeach
    </div>
</div>
<div class="row">
    {{$slot}}
</div>
