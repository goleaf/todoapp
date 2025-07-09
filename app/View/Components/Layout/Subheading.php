<?php

namespace App\View\Components\Layout;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Subheading extends Component
{
    public string $computedClasses;

    /**
     * Create a new component instance.
     */
    public function __construct(public ?string $size = null)
    {
        $this->computedClasses = $this->calculateClasses($size);
    }

    /**
     * Calculate the CSS classes based on the size.
     */
    private function calculateClasses(?string $size): string
    {
        return match ($size) {
            'xl' => 'text-lg',
            'lg' => 'text-base',
            default => 'text-sm',
            'sm' => 'text-xs',
        };
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.subheading.index');
    }
} 