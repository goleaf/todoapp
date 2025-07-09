@props([
    'align' => 'right',
    'width' => '48',
    'contentClasses' => 'p-1 bg-white dark:bg-gray-700',
    'trigger' => null,
])

<div class="relative" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
    <div @click="open = !open">
        {{ $trigger ?? $slot }}
    </div>

    <div 
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute z-50 mt-2 {{ $widthClasses }} rounded-md shadow-lg {{ $alignmentClasses }}"
        style="display: none;"
        @click="open = false"
    >
        <div class="rounded-md ring-1 ring-black ring-opacity-5 border border-gray-200 dark:border-gray-600 {{ $contentClasses }} shadow-xs">
            {{ $menu ?? $slot }}
        </div>
    </div>
</div>
