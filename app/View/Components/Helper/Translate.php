<?php

namespace App\View\Components\Helper;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Closure;

class Translate extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $key,
        public array $params = []
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.helper.translate');
    }
} 