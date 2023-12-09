<div class="mb-5 bg-grey">
    <h4 class="p-2 mb-2 bg-c2 text-white">{{ $question->type->value()}}</h4>
    <p class="mb-2" style="font-size: 1.6em">{!! str()->words($question->body) !!}</p>
    {{ $slot }}
</div>
