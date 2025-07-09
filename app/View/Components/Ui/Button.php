<?php

namespace App\View\Components\Ui;

use App\Services\BladeComponentService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    public string $classes;
    public string $iconClasses;
    public string $iconMarginClasses;

    /**
     * Create a new component instance.
     */
    public function __construct(
        BladeComponentService $bladeComponentService,
        public string $variant = 'primary',
        public string $size = 'md',
        public ?string $icon = null,
        public string $iconPosition = 'left',
        public ?string $href = null,
        public string $type = 'button',
        public bool $disabled = false,
        public ?string $before = null // Added 'before' prop
    )
    {
        $params = [
            'variant' => $this->variant,
            'size' => $this->size,
            'icon' => $this->icon,
            'iconPosition' => $this->iconPosition,
            'disabled' => $this->disabled,
        ];
        $attrs = $bladeComponentService->getButtonAttributes($params);
        $this->classes = $attrs['classes'];
        $this->iconClasses = $attrs['iconClasses'];
        $this->iconMarginClasses = $attrs['iconMarginClasses'];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.button');
    }
} 