<?php

namespace App\View\Components\Layout;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Heading extends Component
{
    public string $computedClasses;
    public string $tag;

    /**
     * Create a new component instance.
     */
    public function __construct(public ?string $size = 'base', public ?string $level = null)
    {
        $this->computedClasses = $this->calculateClasses($size);
        $this->tag = $this->determineTag($level);
    }

    /**
     * Calculate the CSS classes based on the size.
     */
    private function calculateClasses(?string $size): string
    {
        return match ($size) {
            'xl' => 'text-3xl font-bold tracking-tight',
            'lg' => 'text-2xl font-bold tracking-tight',
            'base' => 'text-xl font-semibold',
            'sm' => 'text-lg font-semibold',
            default => 'text-xl font-semibold',
        };
    }
    
    /**
     * Determine the HTML tag based on the heading level.
     */
    private function determineTag(?string $level): string
    {
        if ($level && is_numeric($level) && (int)$level >= 1 && (int)$level <= 6) {
            return 'h' . $level;
        }
        
        return match ($this->size) {
            'xl' => 'h1',
            'lg' => 'h2',
            'base' => 'h3',
            'sm' => 'h4',
            default => 'h3',
        };
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.heading.index');
    }
} 