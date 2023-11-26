<?php

namespace App\View\Components\Questionnaire\Admin;

use App\Models\Questionnaire\Question;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EditType extends Component
{
    public function __construct(
        public Question $question,
        public array    $params,
        private string  $label = '',
        private string  $viewName = ''
    ) {
        $this->viewName = $this->question->type->getEditViewName();
        $this->label = $this->question->type->value();
    }

    public function render(): View|Closure|string
    {
        return view(
            'components.questionnaire.admin.edit-type',
            [
                'viewName' => $this->viewName,
                'label' => $this->label,
                'params' => $this->params,
                'question' => $this->question,
            ]
        );
    }
}
