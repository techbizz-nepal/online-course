@isset($question->describeImage?->questions)
    <div class="row">
        <div class="col-12 mb-2">
            <img width="300px" alt='{{$question->describeImage->question_id}}'
                 src='{{asset(sprintf('%s/%s' , $type->getTypePublicPath(), $question->describeImage->image_path))}}'/>
        </div>
        @foreach($question->describeImage->questions as $item)
            <div class="col-6">
                <p class=" mb-2">Q. <span class="font-weight-bold">{{$item['body']}}</span></p>
                <p class=" mb-4">
                    A. {{$getReadAnswerOrDescribeImageAnswer($item, 'id')['answer']}}
                </p>
            </div>
        @endforeach
    </div>
@endisset
<div class="row">
    {{$slot}}
</div>
