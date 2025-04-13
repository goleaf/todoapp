@props([
    'type' => 'link', // 'link', 'button', 'submit', 'divider'
    'href' => null,
    'before' => null,
    'after' => null,
    'destructive' => false,
])

@php
    $baseClasses = 'group flex items-center px-2 py-2 lg:py-1.5 w-full text-left text-sm font-medium rounded-md';
    
    $typeClasses = match ($type) {
        'link' => 'hover:bg-gray-50 dark:hover:bg-gray-600',
        'button' => 'hover:bg-gray-50 dark:hover:bg-gray-600',
        'submit' => 'hover:bg-gray-50 dark:hover:bg-gray-600',
        'divider' => 'border-t border-gray-200 dark:border-gray-600 my-1',
        default => 'hover:bg-gray-50 dark:hover:bg-gray-600',
    };
    
    $colorClasses = $destructive
        ? 'text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300'
        : 'text-gray-800 dark:text-white hover:text-gray-900 dark:hover:text-gray-100';
    
    $classes = $type !== 'divider' 
        ? $baseClasses . ' ' . $typeClasses . ' ' . $colorClasses 
        : $typeClasses;
@endphp

@if ($type === 'divider')
    <div {{ $attributes->class([$classes]) }}></div>
@elseif ($type === 'link')
    <a href="{{ $href }}" {{ $attributes->class([$classes]) }}>
        @if (is_string($before) && !empty($before))
            <x-ui.dynamic-component :component="$before" aria-hidden="true" width="20" height="20" class="shrink-0 mr-2 text-gray-400 group-hover:text-current" />
        @elseif (!empty($before))
            <span class="shrink-0 mr-2">{{ $before }}</span>
        @endif
        
        @if ($slot->isNotEmpty())
            <div class="flex-1 text-sm font-medium leading-none whitespace-nowrap">{{ $slot }}</div>
        @endif
        
        @if (is_string($after) && !empty($after))
            <x-ui.dynamic-component :component="$after" aria-hidden="true" width="20" height="20" class="shrink-0 ml-2 text-gray-400 group-hover:text-current" />
        @elseif (!empty($after))
            <span class="shrink-0 ml-2">{{ $after }}</span>
        @endif
    </a>
@elseif ($type === 'button' || $type === 'submit')
    <button type="{{ $type }}" {{ $attributes->class([$classes]) }}>
        @if (is_string($before) && !empty($before))
            <x-ui.dynamic-component :component="$before" aria-hidden="true" width="20" height="20" class="shrink-0 mr-2 text-gray-400 group-hover:text-current" />
        @elseif (!empty($before))
            <span class="shrink-0 mr-2">{{ $before }}</span>
        @endif
        
        @if ($slot->isNotEmpty())
            <div class="flex-1 text-sm font-medium leading-none whitespace-nowrap">{{ $slot }}</div>
        @endif
        
        @if (is_string($after) && !empty($after))
            <x-ui.dynamic-component :component="$after" aria-hidden="true" width="20" height="20" class="shrink-0 ml-2 text-gray-400 group-hover:text-current" />
        @elseif (!empty($after))
            <span class="shrink-0 ml-2">{{ $after }}</span>
        @endif
    </button>
@endif
