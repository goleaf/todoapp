@props(['class' => ''])

<button {{ $attributes->merge(['class' => 'p-1 rounded-md text-gray-500 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500' . ($class ? ' ' . $class : '')]) }}
        aria-label="{{ __('components.toggle_sidebar') }}"
>
    <x-ui.icon icon="heroicon-o-bars-3" class="h-6 w-6" />
</button>
