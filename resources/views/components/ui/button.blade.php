@props([
    'variant' => 'primary',
    'size' => 'md',
    'icon' => null,
    'iconPosition' => 'left',
    'type' => 'button',
    'disabled' => false,
    'href' => null,
    'before' => null,
    'classes' => '',
    'iconClasses' => '',
    'iconMarginClasses' => ''
])

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($before)
            <span class="{{ $iconMarginClasses }}">
                @icon($before, $iconClasses)
            </span>
        @endif
        
        @if ($icon && $iconPosition === 'left')
            <span class="{{ $iconMarginClasses }}">
                @icon($icon, $iconClasses)
            </span>
        @endif
        
        {{ $slot }}
        
        @if ($icon && $iconPosition === 'right')
            <span class="{{ $iconMarginClasses }}">
                @icon($icon, $iconClasses)
            </span>
        @endif
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }} @if($disabled) disabled @endif>
        @if ($before)
            <span class="{{ $iconMarginClasses }}">
                @icon($before, $iconClasses)
            </span>
        @endif
        
        @if ($icon && $iconPosition === 'left')
            <span class="{{ $iconMarginClasses }}">
                @icon($icon, $iconClasses)
            </span>
        @endif
        
        {{ $slot }}
        
        @if ($icon && $iconPosition === 'right')
            <span class="{{ $iconMarginClasses }}">
                @icon($icon, $iconClasses)
            </span>
        @endif
    </button>
@endif 