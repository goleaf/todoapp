<?php

namespace App\View\Components\Layout\App;

use Illuminate\View\Component;
use Illuminate\View\View;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View as ViewContract;
use Closure;

class Index extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $title = ''
    ) {
        $this->title = $title ?: config('app.name');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): ViewContract|Closure|string
    {
        return view('components.layout.app.index');
    }
} 