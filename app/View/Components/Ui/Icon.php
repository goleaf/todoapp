<?php

namespace App\View\Components\Ui;

use App\Helpers\IconHelper;
use Illuminate\View\Component;

class Icon extends Component
{
    /**
     * The icon name.
     *
     * @var string|mixed
     */
    public $icon;

    /**
     * The CSS class for the icon.
     *
     * @var string
     */
    public $class;

    /**
     * The icon width.
     *
     * @var int
     */
    public $width;

    /**
     * The icon height.
     *
     * @var int
     */
    public $height;

    /**
     * The resolved icon content.
     *
     * @var string|null
     */
    public $iconContent;

    /**
     * The resolved component name.
     *
     * @var string|null
     */
    public $component;

    /**
     * Create a new component instance.
     *
     * @param string|mixed $icon
     * @param string $class
     * @param int $width
     * @param int $height
     * @return void
     */
    public function __construct($icon, $class = 'w-5 h-5', $width = 24, $height = 24)
    {
        $this->icon = $icon;
        $this->class = $class ?: 'w-5 h-5';
        $this->width = $width;
        $this->height = $height;

        $iconDetails = IconHelper::getIconDetails($icon, $this->class);
        $this->iconContent = $iconDetails['iconContent'];
        $this->component = $iconDetails['component'];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ui.icon');
    }
} 