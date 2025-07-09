<?php

namespace App\View\Components\Input\Input;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Index extends Component
{
    public array $classes;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $formControlAttributes = '',
        public string $size = 'base',
        public ?string $label = null,
        public ?string $id = null,
        public string $value = '',
    )
    {
        $this->classes = $this->calculateClasses($this->size);
    }

    /**
     * Calculate the CSS classes based on the size.
     */
    private function calculateClasses(string $size): array
    {
        return [
            'appearance-none block w-full',
            'pl-3 pr-3',
            'bg-white dark:bg-white/10 dark:disabled:bg-white/[7%]',
            'text-gray-700 disabled:text-gray-500 placeholder-gray-400 disabled:placeholder-gray-400/70 dark:text-gray-300 dark:disabled:text-gray-400 dark:placeholder-gray-400 dark:disabled:placeholder-gray-500',
            'rounded-lg border border-gray-200 border-b-gray-300/80 disabled:border-b-gray-200 dark:border-white/10 dark:disabled:border-white/5',
            'shadow-xs disabled:shadow-none dark:shadow-none',
            'aria-invalid:border-red-500',
            match ($size) {
                'base' => 'text-base sm:text-sm py-2 h-10 leading-[1.375rem]',
                'sm' => 'text-sm py-1.5 h-8 leading-[1.125rem]',
                'xs' => 'text-xs py-1.5 h-6 leading-[1.125rem]',
            },
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.input.input.index');
    }
} 