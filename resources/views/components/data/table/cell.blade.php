@props([

    'type' => 'default', // 'default', 'primary', 'action'
])



















@php
    $classes = [
        'default' => 'whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400',
        'primary' => 'whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 dark:text-gray-100 sm:pl-6',
        'action' => 'relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6',
    ];
@endphp

<td {{ $attributes->merge(['class' => $classes[$type]]) }}>
    {{ $slot }}
</td> 