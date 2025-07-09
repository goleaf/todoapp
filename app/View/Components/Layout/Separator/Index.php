<?php

namespace App\View\Components\Layout\Separator;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Closure;

class Index extends Component
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
        return view('components.layout.separator.index');
    }
} 