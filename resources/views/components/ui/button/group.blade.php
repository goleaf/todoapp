@props([])

@php
    // Initialize required variables if they don't exist
    $attributes = $attributes ?? collect();
    $slot = $slot ?? '';
    $classes = $classes ?? '';
    $iconClasses = $iconClasses ?? '';
    $iconMarginClasses = $iconMarginClasses ?? '';
    
    // Get attributes from component service if not already set
    if (empty($classes)) {
        $params = [
            'variant' => $variant ?? 'primary',
            'size' => $size ?? 'md',
            'icon' => $icon ?? null,
            'iconPosition' => $iconPosition ?? 'left',
            'disabled' => $disabled ?? false,
        ];
        $attrs = app(\App\Services\BladeComponentService::class)->getButtonAttributes($params);
        $classes = $attrs['classes'];
        $iconClasses = $attrs['iconClasses'];
        $iconMarginClasses = $attrs['iconMarginClasses'];
    }
@endphp

<div {{ $attributes->class([
    'flex -space-x-px group/button',
    '[&>button:not(:first-child):not(:last-child)]:rounded-none',
    '[&>button:first-child:not(:last-child)]:rounded-r-none',
    '[&>button:last-child:not(:first-child)]:rounded-l-none',
    '[&>button:last-child:not(:first-child)]:rounded-l-none',
]) }} data-button-group>
    {{ $slot }}
</div>
