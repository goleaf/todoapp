@props([
    'type' => 'link', // 'link', 'button', 'submit', 'divider'
    'href' => null,
    'icon' => null,
    'destructive' => false,
])

@php
    $baseClasses = 'block w-full px-4 py-2 text-left text-sm focus:outline-none transition duration-150 ease-in-out';
    
    $typeClasses = match ($type) {
        'link' => 'hover:bg-gray-100 dark:hover:bg-gray-700',
        'button' => 'hover:bg-gray-100 dark:hover:bg-gray-700',
        'submit' => 'hover:bg-gray-100 dark:hover:bg-gray-700',
        'divider' => 'border-t border-gray-200 dark:border-gray-600 my-1',
        default => 'hover:bg-gray-100 dark:hover:bg-gray-700',
    };
    
    $colorClasses = $destructive
        ? 'text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300'
        : 'text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100';
    
    $classes = $type !== 'divider' 
        ? $baseClasses . ' ' . $typeClasses . ' ' . $colorClasses 
        : $typeClasses;
@endphp

@if ($type === 'divider')
    <div class="{{ $classes }}"></div>
@elseif ($type === 'link')
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon)
            <span class="inline-flex items-center">
                <span class="w-5 h-5 mr-2">{{ $icon }}</span>
                <span>{{ $slot }}</span>
            </span>
        @else
            {{ $slot }}
        @endif
    </a>
@elseif ($type === 'button')
    <button type="button" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon)
            <span class="inline-flex items-center">
                <span class="w-5 h-5 mr-2">{{ $icon }}</span>
                <span>{{ $slot }}</span>
            </span>
        @else
            {{ $slot }}
        @endif
    </button>
@elseif ($type === 'submit')
    <button type="submit" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon)
            <span class="inline-flex items-center">
                <span class="w-5 h-5 mr-2">{{ $icon }}</span>
                <span>{{ $slot }}</span>
            </span>
        @else
            {{ $slot }}
        @endif
    </button>
@endif 