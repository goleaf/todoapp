<?php

namespace App\View\Components\Ui;

use App\Helpers\BadgeHelper;
use Illuminate\View\Component;

class Badge extends Component
{
    /**
     * The badge color.
     *
     * @var string
     */
    public $color;

    /**
     * The badge size.
     *
     * @var string
     */
    public $size;

    /**
     * The badge icon.
     *
     * @var mixed
     */
    public $icon;

    /**
     * The computed color classes.
     *
     * @var string
     */
    public $colorClasses;

    /**
     * The computed size classes.
     *
     * @var string
     */
    public $sizeClasses;

    /**
     * Create a new component instance.
     *
     * @param string $color
     * @param string $size
     * @param mixed $icon
     * @return void
     */
    public function __construct($color = 'gray', $size = 'md', $icon = null)
    {
        $this->color = $color;
        $this->size = $size;
        $this->icon = $icon;
        $this->colorClasses = BadgeHelper::getColorClasses($color);
        $this->sizeClasses = BadgeHelper::getSizeClasses($size);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ui.badge.index');
    }
} 