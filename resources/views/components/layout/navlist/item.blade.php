@aware(['variant' => 'primary'])

@props([
    'current' => false,
    'before' => '',
    'after' => '',
])

@php
use Illuminate\Support\Str;
@endphp

<a aria-current="{{ $current ? 'page' : '' }}" {{ $attributes->class([
    'h-10 lg:h-8 relative flex items-center space-x-2 rounded-lg',
    'py-0 text-left w-full px-3 my-px',
    'text-gray-500 dark:text-white/80',
    'border border-transparent',
    'aria-current:text-(--color-accent-content) hover:aria-current:text-(--color-accent-content)',
    match($variant ?? 'primary') { // Hover...
        'secondary' => 'hover:text-gray-800 dark:hover:text-white hover:bg-gray-800/[4%] dark:hover:bg-white/[7%]',
        default => 'hover:text-gray-800 dark:hover:text-white hover:bg-gray-800/5 dark:hover:bg-white/[7%]',
    },
    match($variant ?? 'primary') { // Current...
        'secondary' => 'aria-current:bg-gray-800/[4%] dark:aria-current:bg-white/[7%]',
        default => 'aria-current:bg-white dark:aria-current:bg-white/[7%] aria-current:border aria-current:border-gray-200 dark:aria-current:border-transparent',
    },
]) }}>
    @if (is_string($before) && $before !== '')
        @if (Str::startsWith($before, 'phosphor-') || Str::startsWith($before, 'heroicon-'))
            <x-ui.icon :icon="$before" aria-hidden="true" width="16" height="16" class="shrink-0" />
        @else
            <x-ui.dynamic-component :component="$before" aria-hidden="true" width="16" height="16" class="shrink-0" />
        @endif
    @else
        {{ $before }}
    @endif
    @if ($slot->isNotEmpty())
        <div class="flex-1 text-sm font-medium leading-none whitespace-nowrap">{{ $slot }}</div>
    @endif
    @if (is_string($after) && $after !== '')
        @if (Str::startsWith($after, 'phosphor-') || Str::startsWith($after, 'heroicon-'))
            <x-ui.icon :icon="$after" aria-hidden="true" width="16" height="16" class="shrink-0 ml-1" />
        @else
            <x-ui.dynamic-component :component="$after" aria-hidden="true" width="16" height="16" class="shrink-0 ml-1" />
        @endif
    @else
        {{ $after }}
    @endif
</a>
