@props([

    'hover' => true,
])



















@php
    $classes = $hover ? 'hover:bg-gray-50 dark:hover:bg-gray-700/50' : '';
@endphp

<tr {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</tr> 