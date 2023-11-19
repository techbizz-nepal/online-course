<?php

namespace App\Questionnaire\Services\Student;

use App\DTO\Questionnaire\AnswerData;
use App\Models\Questionnaire\Answer;
use App\Models\Questionnaire\Exam;
use App\Models\Questionnaire\Question;

class BaseStudent
{
    protected array $submittedAnswer;

    protected Exam $exam;

    protected Question $question;

    protected AnswerData $answerData;

    public function submit(): static
    {
        $this->submittedAnswer = Answer::query()->updateOrCreate(
            ['exam_id' => $this->answerData->exam_id, 'question_id' => $this->answerData->question_id],
            ['answer' => $this->answerData->answer]
        )->toArray();

        return $this;
    }

    public function getResult(string $relation): bool
    {
        $result = $this->question->{$relation}?->answer == $this->submittedAnswer['answer'];
        $this->answerData->is_correct = $result;

        Answer::query()->updateOrCreate(
            $this->answerData->only('exam_id', 'question_id')->toArray(),
            ['is_correct' => $this->answerData->is_correct]
        );

        return $result;
    }
}
