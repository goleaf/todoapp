@props([
    'header' => null,
    'footer' => null,
    'padding' => 'normal',
    'withShadow' => true,
    'withBorder' => false,
    'withHover' => false
])

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