@props([
    'placeholder' => __('Search...'),
    'route' => null,
    'name' => 'q'
])

<div {{ $attributes->merge(['class' => 'max-w-lg w-full lg:max-w-xs']) }}>
    <label for="search-input" class="sr-only">{{ __('Search') }}</label>
    <form action="{{ $route }}" method="GET" class="w-full">
        <div class="relative rounded-md shadow-sm">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                <x-ui.icon icon="heroicon-o-magnifying-glass" class="h-5 w-5 text-gray-400 dark:text-gray-500" />
            </div>
            <input 
                id="search-input"
                type="search" 
                name="{{ $name }}" 
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md leading-5 bg-white dark:bg-gray-800 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition" 
                placeholder="{{ $placeholder }}" 
                value="{{ request($name) }}"
            />
            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                <kbd class="hidden sm:inline-flex items-center px-2 rounded border border-gray-200 dark:border-gray-600 font-sans text-xs text-gray-400 dark:text-gray-500">
                    /
                </kbd>
            </div>
        </div>
    </form>
</div> 