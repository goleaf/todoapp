@props(['icon', 'classes'])

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

@if ($icon)
    <x-ui.icon :icon="$icon" :class="$classes" />
@endif 