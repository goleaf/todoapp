<?php

namespace App\View\Components\Layout\SectionHeader;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Closure;

class Index extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $title,
        public ?string $description = null,
        public $actions = null
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.section-header.index');
    }
} 