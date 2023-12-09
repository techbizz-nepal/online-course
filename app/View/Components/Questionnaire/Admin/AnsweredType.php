<?php

namespace App\View\Components\Questionnaire\Admin;

use App\Enums\Questionnaire\QuestionType;
use App\Models\Questionnaire\Question;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\View\Component;

class AnsweredType extends Component
{
    public function __construct(
        public Question $question,
        public array|string $studentAnswer = [],
        public array $answerStatusArray = []
    ) {
        $this->studentAnswer = json_decode($this->question->pivot->answer, true);
    }

    public function render(): View|Closure|string
    {
        return view($this->getViewName(), $this->getViewData());
    }

    private function getViewName(): string
    {
        return $this->question->type->getResultViewName();
    }

    private function getViewData(): array
    {
        $type = $this->question->type;

        return [
            'question' => $this->question->load($type->relation()),
            'answerArray' => json_decode($this->question->pivot->answer, true),
            'type' => $type,
        ];
    }

    public function compareSeeAndAnswer(array $question, string $compareKey): ?static
    {
        if (! in_array($this->question->type->value, QuestionType::getReviewTypes())) {
            return null;
        }

        $result = Arr::first($this->studentAnswer, function ($answer) use ($compareKey, $question) {
            $this->answerStatusArray[$question['id']]['answer'] = $answer['name'];

            return $answer[$compareKey] == $question[$compareKey];
        });
        if (($result !== null) && ($question['id'] == $result['id'])) {
            $this->answerStatusArray[$question['id']]['class'] = 'text-success';
        } else {
            $this->answerStatusArray[$question['id']]['class'] = 'text-danger';
        }

        return $this;
    }

    public function getSeeAndAnswerAnswer(string $key)
    {
        return $this->answerStatusArray[$key]['answer'];
    }

    public function getReadAnswerOrDescribeImageAnswer(array $question, $compareKey)
    {
        return Arr::first($this->studentAnswer, function ($answer) use ($compareKey, $question) {
            return $answer[$compareKey] == $question[$compareKey];
        });
    }

    public function getTrueFalseAnswer(): string
    {
        $answer = json_decode($this->studentAnswer, true);

        return $answer ? 'True' : 'False';
    }

    public function getClosedOptionAnswer(): ?string
    {
        return $this->studentAnswer;
    }
}
