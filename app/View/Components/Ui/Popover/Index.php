<?php

namespace App\View\Components\Ui\Popover;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Closure;

class Index extends Component
{
    public string $alignmentClasses;
    public string $widthClasses;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $align = 'right',
        public string $width = '48',
        public string $contentClasses = 'p-1 bg-white dark:bg-gray-700',
        public $trigger = null
    ) {
        $this->alignmentClasses = $this->getAlignmentClasses($align);
        $this->widthClasses = $this->getWidthClasses($width);
    }

    /**
     * Calculate alignment classes based on align value.
     */
    private function getAlignmentClasses(string $align): string
    {
        return match ($align) {
            'left' => 'origin-top-left left-0',
            'top' => 'origin-top',
            'bottom' => 'origin-bottom',
            'right' => 'origin-top-right right-0',
            'left-bottom' => 'origin-bottom-left left-0 bottom-0',
            'right-bottom' => 'origin-bottom-right right-0 bottom-0',
            default => 'origin-top-right right-0',
        };
    }

    /**
     * Calculate width classes based on width value.
     */
    private function getWidthClasses(string $width): string
    {
        return match ($width) {
            '48' => 'w-48',
            '56' => 'w-56',
            '64' => 'w-64',
            '72' => 'w-72',
            '80' => 'w-80',
            'auto' => 'w-auto',
            default => 'w-48',
        };
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.popover.index');
    }
} 