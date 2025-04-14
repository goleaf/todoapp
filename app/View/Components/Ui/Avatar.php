<?php

namespace App\View\Components\Ui;

use App\Helpers\AvatarHelper;
use Illuminate\View\Component;

class Avatar extends Component
{
    /**
     * The image source URL.
     *
     * @var string|null
     */
    public $src;

    /**
     * The image alt text.
     *
     * @var string
     */
    public $alt;

    /**
     * The avatar size.
     *
     * @var string
     */
    public $size;

    /**
     * The user name for generating initials.
     *
     * @var string|null
     */
    public $name;

    /**
     * The status indicator.
     *
     * @var string|null
     */
    public $status;

    /**
     * The status position.
     *
     * @var string
     */
    public $statusPosition;

    /**
     * Whether the avatar is square.
     *
     * @var bool
     */
    public $square;

    /**
     * The size classes based on size.
     *
     * @var array
     */
    public $sizeClasses;

    /**
     * The status sizes based on avatar size.
     *
     * @var array
     */
    public $statusSizes;

    /**
     * The status colors.
     *
     * @var array
     */
    public $statusColors;

    /**
     * The status positions.
     *
     * @var array
     */
    public $statusPositions;

    /**
     * The border radius class.
     *
     * @var string
     */
    public $borderRadius;

    /**
     * The user initials.
     *
     * @var string
     */
    public $initials;

    /**
     * Create a new component instance.
     *
     * @param string|null $src
     * @param string $alt
     * @param string $size
     * @param string|null $name
     * @param string|null $status
     * @param string $statusPosition
     * @param bool $square
     * @return void
     */
    public function __construct(
        $src = null,
        $alt = 'Avatar',
        $size = 'md',
        $name = null,
        $status = null,
        $statusPosition = 'bottom-right',
        $square = false
    ) {
        $this->src = $src;
        $this->alt = $alt;
        $this->size = $size;
        $this->name = $name;
        $this->status = $status;
        $this->statusPosition = $statusPosition;
        $this->square = $square;
        
        $this->sizeClasses = AvatarHelper::getSizeClasses();
        $this->statusSizes = AvatarHelper::getStatusSizes();
        $this->statusColors = AvatarHelper::getStatusColors();
        $this->statusPositions = AvatarHelper::getStatusPositions();
        $this->borderRadius = AvatarHelper::getBorderRadius($square);
        $this->initials = AvatarHelper::getInitials($name);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ui.avatar.index');
    }
} 