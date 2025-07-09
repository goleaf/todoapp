<?php

namespace App\View\Components\Auth\AuthSessionStatus;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Closure;

class Index extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $status = null
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.auth.auth-session-status.index');
    }
} 