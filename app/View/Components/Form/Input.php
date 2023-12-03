<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    public function __construct(
        public string $label,
        public string $name,
        public string $id,
        public string $cols,
        public string $type = 'text',
        public string $placeholder = '',
        public ?string $value = '',
        public ?string $pattern = null,
        public bool $required = false,
        public bool $readonly = false
    ) {
        $this->fillInput();
    }

    public function fillInput(): void
    {
        $this->value = $this->value ?? old($this->name);
    }

    public function render(): View|Closure|string
    {
        return view('components.form.input');
    }
}
