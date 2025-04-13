@props([
    'align' => 'right',
    'width' => '48',
    'contentClasses' => 'py-1 bg-white dark:bg-gray-700',
])

@php
    $alignmentClasses = match ($align) {
        'left' => 'origin-top-left left-0',
        'top' => 'origin-top',
        'bottom' => 'origin-bottom',
        'right' => 'origin-top-right right-0',
        default => 'origin-top-right right-0',
    };

    $widthClasses = match ($width) {
        '48' => 'w-48',
        '56' => 'w-56',
        '64' => 'w-64',
        '72' => 'w-72',
        '80' => 'w-80',
        'auto' => 'w-auto',
        default => 'w-48',
    };
@endphp

<div {{ $attributes->class(['relative']) }}>
    <div 
        class="absolute z-50 mt-2 {{ $widthClasses }} rounded-md shadow-lg {{ $alignmentClasses }}"
    >
        <div class="rounded-md ring-1 ring-black ring-opacity-5 border border-gray-200 dark:border-gray-600 {{ $contentClasses }}">
            {{ $slot }}
        </div>
    </div>
</div> 