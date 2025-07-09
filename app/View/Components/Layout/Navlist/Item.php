<?php

namespace App\View\Components\Layout\Navlist;

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
        public $before = '',
        public $after = '',
        public ?string $variant = null
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.navlist.item');
    }
} 