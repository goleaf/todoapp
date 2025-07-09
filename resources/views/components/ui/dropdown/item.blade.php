@props([

    'href' => '#',
    'icon' => null,
    'iconPosition' => 'left',
])

















<a href="{{ $href }}" {{ $attributes->class([
    'flex items-center w-full px-4 py-2 text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out'
]) }}>
    @if ($icon && $iconPosition === 'left')
        <x-ui.dynamic-component :component="$icon" class="mr-2 -ml-1 h-5 w-5 text-gray-500 dark:text-gray-400" />
    @endif

    <span>{{ $slot }}</span>

    @if ($icon && $iconPosition === 'right')
        <x-ui.dynamic-component :component="$icon" class="ml-2 -mr-1 h-5 w-5 text-gray-500 dark:text-gray-400" />
    @endif
</a> 