@isset($question->readAndAnswer?->questions)

    <div class="row">
        @foreach($question->readAndAnswer->questions as $item)
            <div class="col-6">
                <p class=" mb-2">Q. <span class="font-weight-bold">{{$item['body']}}</span></p>
                <p class=" mb-4">
                    A. {{$getReadAnswerOrDescribeImageAnswer($item, 'id')['answer']}}
                </p>
            </div>
        @endforeach
    </div>
@endisset
