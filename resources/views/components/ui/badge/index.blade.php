@props([
    'color' => 'gray', 
    'size' => 'md',
    'icon' => null
])

<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-md font-medium ring-1 ring-inset ' . $colorClasses . ' ' . $sizeClasses]) }}>
    @if($icon)
        <span class="-ml-0.5 mr-1.5">
            {{ $icon }}
        </span>
    @endif
    {{ $slot }}
</span> 