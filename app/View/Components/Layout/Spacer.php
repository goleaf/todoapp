<?php

namespace App\View\Components\Layout;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Closure;

class Spacer extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.spacer');
    }
} 