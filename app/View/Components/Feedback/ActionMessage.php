<?php

namespace App\View\Components\Feedback;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Closure;

class ActionMessage extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $on
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.feedback.action-message');
    }
} 