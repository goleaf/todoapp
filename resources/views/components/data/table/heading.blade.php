@props([
    'sortable' => false,
    'sortDirection' => null,
    'sortField' => null,
    'currentSort' => null,
])







{{-- Define the class string directly in the attributes merge --}}
<th {{ $attributes->merge([
    'class' => 'py-3.5 px-3 text-left text-sm font-semibold text-gray-900 dark:text-gray-100' . 
              ($sortable ? ' cursor-pointer select-none' : ''),
    'scope' => 'col'
]) }}>
    @if ($sortable)
        <div class="flex items-center group">
            <span>{{ $slot }}</span>
            
            <span class="ml-2 flex-none rounded">
                @if ($sortField === $currentSort && $sortDirection === 'asc')
                    <x-ui.icon icon="heroicon-s-chevron-up" class="h-4 w-4 text-gray-400" />
                @elseif ($sortField === $currentSort && $sortDirection === 'desc')
                    <x-ui.icon icon="heroicon-s-chevron-down" class="h-4 w-4 text-gray-400" />
                @else
                    <x-ui.icon icon="heroicon-o-arrows-up-down" class="invisible group-hover:visible h-4 w-4 text-gray-400" />
                @endif
            </span>
        </div>
    @else
        {{ $slot }}
    @endif
</th> 