<?php

namespace App\View\Components\Layout;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PlaceholderPattern extends Component
{
    public string $id;

    /**
     * Create a new component instance.
     */
    public function __construct(?string $id = null)
    {
        $this->id = $id ?? uniqid();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.placeholder-pattern.index');
    }
} 