<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string  $label,
        public string  $name,
        public string  $id,
        public string  $cols,
        public array   $options = [],
        public string  $type = 'text',
        public string  $placeholder = '',
        public ?string $selected = null,
        public ?string $value = '',
    ) {
        //
    }

    public function render(): View|Closure|string
    {
        return view('components.form.select');
    }
}
