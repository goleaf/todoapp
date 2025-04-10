@props([
    'color' => 'gray', 
    'size' => 'md',
    'icon' => null
])

@php
    $colorClasses = [
        'gray' => 'bg-gray-50 dark:bg-gray-400/10 text-gray-600 dark:text-gray-400 ring-gray-500/10 dark:ring-gray-400/20',
        'red' => 'bg-red-50 dark:bg-red-400/10 text-red-700 dark:text-red-400 ring-red-600/10 dark:ring-red-400/20',
        'yellow' => 'bg-yellow-50 dark:bg-yellow-400/10 text-yellow-800 dark:text-yellow-500 ring-yellow-600/20 dark:ring-yellow-400/20',
        'green' => 'bg-green-50 dark:bg-green-400/10 text-green-700 dark:text-green-400 ring-green-600/20 dark:ring-green-400/20',
        'blue' => 'bg-blue-50 dark:bg-blue-400/10 text-blue-700 dark:text-blue-400 ring-blue-700/10 dark:ring-blue-400/30',
        'indigo' => 'bg-indigo-50 dark:bg-indigo-400/10 text-indigo-700 dark:text-indigo-400 ring-indigo-700/10 dark:ring-indigo-400/30',
        'purple' => 'bg-purple-50 dark:bg-purple-400/10 text-purple-700 dark:text-purple-400 ring-purple-700/10 dark:ring-purple-400/30',
        'pink' => 'bg-pink-50 dark:bg-pink-400/10 text-pink-700 dark:text-pink-400 ring-pink-700/10 dark:ring-pink-400/30',
    ];
    
    $sizeClasses = [
        'sm' => 'px-1.5 py-0.5 text-xs',
        'md' => 'px-2 py-1 text-xs',
        'lg' => 'px-2.5 py-1.5 text-sm'
    ];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-md font-medium ring-1 ring-inset ' . $colorClasses[$color] . ' ' . $sizeClasses[$size]]) }}>
    @if($icon)
        <span class="-ml-0.5 mr-1.5">
            {{ $icon }}
        </span>
    @endif
    {{ $slot }}
</span> 