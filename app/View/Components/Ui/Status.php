<?php

namespace App\View\Components\Ui;

use App\Helpers\StatusHelper;
use Illuminate\View\Component;

class Status extends Component
{
    /**
     * The status value.
     *
     * @var string
     */
    public $status;

    /**
     * The status type.
     *
     * @var string
     */
    public $type;

    /**
     * Whether the status is small.
     *
     * @var bool
     */
    public $small;

    /**
     * The computed status color classes.
     *
     * @var string
     */
    public $statusColors;

    /**
     * The computed size classes.
     *
     * @var string
     */
    public $sizeClasses;

    /**
     * Create a new component instance.
     *
     * @param string $status
     * @param string $type
     * @param bool $small
     * @return void
     */
    public function __construct($status = 'default', $type = 'status', $small = false)
    {
        $this->status = $status;
        $this->type = $type;
        $this->small = $small;
        $this->statusColors = StatusHelper::getStatusColors($status);
        $this->sizeClasses = StatusHelper::getSizeClasses($small);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ui.status.index');
    }
} 