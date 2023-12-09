<?php

namespace App\View\Components\Questionnaire\Admin;

use App\Models\Questionnaire\Question;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AnsweredQuestion extends Component
{
    public function __construct(public Question $question)
    {
        //
    }

    public function render(): View|Closure|string
    {
        return view('components.questionnaire.admin.answered-question');
    }
}
