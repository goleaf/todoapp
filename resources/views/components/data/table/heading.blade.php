@props([
    'sortable' => false,
    'sortDirection' => null,
    'sortField' => null,
    'currentSort' => null,
])

@php
    $classes = 'py-3.5 px-3 text-left text-sm font-semibold text-gray-900 dark:text-gray-100';
    
    if ($sortable) {
        $classes .= ' cursor-pointer select-none';
    }
@endphp

<th {{ $attributes->merge(['class' => $classes, 'scope' => 'col']) }}>
    @if ($sortable)
        <div class="flex items-center group">
            <span>{{ $slot }}</span>
            
            <span class="ml-2 flex-none rounded">
                @if ($sortField === $currentSort && $sortDirection === 'asc')
                    <x-heroicon-s-chevron-up class="h-4 w-4 text-gray-400" />
                @elseif ($sortField === $currentSort && $sortDirection === 'desc')
                    <x-heroicon-s-chevron-down class="h-4 w-4 text-gray-400" />
                @else
                    <x-heroicon-o-arrows-up-down class="invisible group-hover:visible h-4 w-4 text-gray-400" />
                @endif
            </span>
        </div>
    @else
        {{ $slot }}
    @endif
</th> 