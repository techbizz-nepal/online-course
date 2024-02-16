@isset($question->readAndAnswer?->questions)

    <div class="row">
        @foreach($question->readAndAnswer->questions as $item)
            <div class="col-6">
                <p class=" mb-2"><span class="font-weight-bold">{{$item['body']}}</span></p>
                <p class=" mb-4">
                   {{$getReadAnswerOrDescribeImageAnswer($item, 'id')['answer']}}
                </p>
            </div>
        @endforeach
    </div>
@endisset
<div class="row">
    {{$slot}}
</div>
