<?php

namespace App\View\Components\Layout\Navbar;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Closure;

class Item extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public bool $current = false,
        public string|object $before = '',
        public string|object $after = ''
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.navbar.item');
    }
} 