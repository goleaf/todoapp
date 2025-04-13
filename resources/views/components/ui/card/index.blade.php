@props([
    'header' => null,
    'footer' => null,
    'padding' => 'normal',
    'withShadow' => true,
    'withBorder' => false,
    'withHover' => false
])

@php
    $paddingClasses = [
        'none' => '',
        'sm' => 'p-3 sm:p-4',
        'normal' => 'p-4 sm:p-6',
        'lg' => 'p-6 sm:p-8'
    ];
    
    $classes = ['bg-white dark:bg-gray-800 rounded-lg'];
    
    if ($withShadow) {
        $classes[] = 'shadow-sm';
    }
    
    if ($withBorder) {
        $classes[] = 'border border-gray-200 dark:border-gray-700';
    }
    
    if ($withHover) {
        $classes[] = 'transition-all duration-200 hover:shadow-md';
    }
@endphp

<div {{ $attributes->merge(['class' => implode(' ', $classes)]) }}>
    @if($header)
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
            {{ $header }}
        </div>
    @endif
    
    <div class="{{ $paddingClasses[$padding] }}">
        {{ $slot }}
    </div>
    
    @if($footer)
        <div class="px-4 py-4 sm:px-6 border-t border-gray-200 dark:border-gray-700">
            {{ $footer }}
        </div>
    @endif
</div> 