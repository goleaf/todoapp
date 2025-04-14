<?php

namespace App\View\Components\Ui;

use App\Helpers\TooltipHelper;
use Illuminate\View\Component;

class Tooltip extends Component
{
    /**
     * The tooltip text.
     *
     * @var string
     */
    public $text;

    /**
     * The tooltip position.
     *
     * @var string
     */
    public $position;

    /**
     * The position classes.
     *
     * @var string
     */
    public $positionClasses;

    /**
     * The arrow classes.
     *
     * @var string
     */
    public $arrowClasses;

    /**
     * Create a new component instance.
     *
     * @param string $text
     * @param string $position
     * @return void
     */
    public function __construct($text = '', $position = 'top')
    {
        $this->text = $text;
        $this->position = $position;
        $this->positionClasses = TooltipHelper::getPositionClasses($position);
        $this->arrowClasses = TooltipHelper::getArrowClasses($position);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ui.tooltip');
    }
} 