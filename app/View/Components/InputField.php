<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InputField extends Component
{

    public function __construct(
        public string $name,
        public ?string $label = null,
        public string $type = 'text',
        public $value = null,
        public ?string $placeholder = null,
        public bool $required = false,
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.input-field');
    }
}
