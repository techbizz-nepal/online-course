<?php

namespace App\View\Components\Questionnaire\Admin;

use App\Enums\Questionnaire\QuestionType;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CreateType extends Component
{
    public function __construct(
        public array $params,
        public string $label = '',
        private string $viewName = ''
    ) {
        $this->viewName = QuestionType::from($this->params['type'])->getCreateViewName();
        $this->label = QuestionType::from($this->params['type'])->value();
    }

    public function render(): View|Closure|string
    {
        return view(
            'components.questionnaire.admin.create-type',
            [
                'viewName' => $this->viewName,
                'label' => $this->label,
                'params' => $this->params,
            ]
        );
    }
}
