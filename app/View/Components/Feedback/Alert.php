<?php

namespace App\View\Components\Feedback;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Closure;

class Alert extends Component
{
    public array $typeClasses;
    public array $iconColors;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $type = 'success',
        public bool $dismissible = true,
        public ?string $message = null
    ) {
        $this->typeClasses = [
            'success' => 'bg-green-50 dark:bg-green-900/20 text-green-800 dark:text-green-300',
            'error' => 'bg-red-50 dark:bg-red-900/20 text-red-800 dark:text-red-300',
            'warning' => 'bg-yellow-50 dark:bg-yellow-900/20 text-yellow-800 dark:text-yellow-300',
            'info' => 'bg-blue-50 dark:bg-blue-900/20 text-blue-800 dark:text-blue-300',
        ];

        $this->iconColors = [
            'success' => 'text-green-400 dark:text-green-300',
            'error' => 'text-red-400 dark:text-red-300',
            'warning' => 'text-yellow-400 dark:text-yellow-300',
            'info' => 'text-blue-400 dark:text-blue-300',
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.feedback.alert');
    }
} 