<?php

namespace App\View\Components\Ui;

use App\Helpers\CardHelper;
use Illuminate\View\Component;

class Card extends Component
{
    /**
     * The card header slot.
     *
     * @var mixed
     */
    public $header;

    /**
     * The card footer slot.
     *
     * @var mixed
     */
    public $footer;

    /**
     * The card padding size.
     *
     * @var string
     */
    public $padding;

    /**
     * Whether the card has shadow.
     *
     * @var bool
     */
    public $withShadow;

    /**
     * Whether the card has border.
     *
     * @var bool
     */
    public $withBorder;

    /**
     * Whether the card has hover effect.
     *
     * @var bool
     */
    public $withHover;

    /**
     * The padding classes.
     *
     * @var array
     */
    public $paddingClasses;

    /**
     * The card classes.
     *
     * @var array
     */
    public $classes;

    /**
     * Create a new component instance.
     *
     * @param mixed $header
     * @param mixed $footer
     * @param string $padding
     * @param bool $withShadow
     * @param bool $withBorder
     * @param bool $withHover
     * @return void
     */
    public function __construct($header = null, $footer = null, $padding = 'normal', $withShadow = true, $withBorder = false, $withHover = false)
    {
        $this->header = $header;
        $this->footer = $footer;
        $this->padding = $padding;
        $this->withShadow = $withShadow;
        $this->withBorder = $withBorder;
        $this->withHover = $withHover;
        $this->paddingClasses = CardHelper::getPaddingClasses();
        $this->classes = CardHelper::getCardClasses($withShadow, $withBorder, $withHover);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ui.card.index');
    }
} 