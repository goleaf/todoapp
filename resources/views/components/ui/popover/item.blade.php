@props([

    'type' => 'link', // 'link', 'button', 'submit', 'divider'
    'href' => null,
    'before' => null,
    'after' => null,
    'destructive' => false,
])

















{{-- PHP logic moved to BladeComponentService --}}

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
