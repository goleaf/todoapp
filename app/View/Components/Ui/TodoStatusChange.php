<?php

namespace App\View\Components\Ui;

use App\Helpers\TodoStatusHelper;
use App\Models\Todo;
use Illuminate\View\Component;

class TodoStatusChange extends Component
{
    /**
     * The todo model.
     *
     * @var \App\Models\Todo
     */
    public $todo;

    /**
     * Whether to display the status name.
     *
     * @var bool
     */
    public $displayName;

    /**
     * The component size.
     *
     * @var string
     */
    public $size;

    /**
     * The status options.
     *
     * @var array
     */
    public $statusOptions;

    /**
     * The icon map.
     *
     * @var array
     */
    public $iconMap;

    /**
     * The size classes.
     *
     * @var array
     */
    public $sizeClasses;

    /**
     * Create a new component instance.
     *
     * @param \App\Models\Todo $todo
     * @param bool $displayName
     * @param string $size
     * @return void
     */
    public function __construct(Todo $todo, bool $displayName = true, string $size = 'md')
    {
        $this->todo = $todo;
        $this->displayName = $displayName;
        $this->size = $size;
        $this->statusOptions = TodoStatusHelper::getStatusOptions();
        $this->iconMap = TodoStatusHelper::getIconMap();
        $this->sizeClasses = TodoStatusHelper::getSizeClasses();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ui.todo-status-change');
    }
} 