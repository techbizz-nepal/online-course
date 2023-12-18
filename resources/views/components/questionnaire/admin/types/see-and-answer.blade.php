@isset($question->seeAndAnswer?->items)
    <div class="row">
        @foreach($question->seeAndAnswer->items as $item)
            <div class="col-3">
                <p class="my-3">Correct Name: {{$item['name']}}</p>
                <p  class="my-3"><img width="600px" alt='{{$item['name']}}'
                                          src='{{asset(sprintf('%s/%s' , $type->getTypePublicPath(), $item['image_path']))}}'/>
                </p>
                <p  class="my-3">Student Answer:
                    <span @class([$compareSeeAndAnswer($item, 'name')->answerStatusArray[$item['id']]['class']])>
                        {{$getSeeAndAnswerAnswer($item['id'])}}
                    </span>
                </p>

            </div>
        @endforeach
    </div>
@endisset
<div class="row">
    {{$slot}}
</div>
