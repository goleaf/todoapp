@props([
    'status' => 'default',
    'type' => 'status',
    'small' => false
])

@php
    $statusColors = [
        // Status colors
        'pending' => 'bg-gray-50 text-gray-700 ring-1 ring-inset ring-gray-600/20 dark:bg-gray-900/30 dark:text-gray-400 dark:ring-gray-500/20',
        'in_progress' => 'bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-600/20 dark:bg-blue-900/30 dark:text-blue-400 dark:ring-blue-500/20',
        'completed' => 'bg-green-50 text-green-700 ring-1 ring-inset ring-green-600/20 dark:bg-green-900/30 dark:text-green-400 dark:ring-green-500/20',
        
        // Priority colors
        'high' => 'bg-red-50 text-red-700 ring-1 ring-inset ring-red-600/20 dark:bg-red-900/30 dark:text-red-400 dark:ring-red-500/20',
        'medium' => 'bg-yellow-50 text-yellow-700 ring-1 ring-inset ring-yellow-600/20 dark:bg-yellow-900/30 dark:text-yellow-400 dark:ring-yellow-500/20',
        'low' => 'bg-green-50 text-green-700 ring-1 ring-inset ring-green-600/20 dark:bg-green-900/30 dark:text-green-400 dark:ring-green-500/20',
        
        // Default color
        'default' => 'bg-gray-50 text-gray-700 ring-1 ring-inset ring-gray-600/20 dark:bg-gray-900/30 dark:text-gray-400 dark:ring-gray-500/20',
    ];

    $sizeClasses = $small 
        ? 'px-1.5 py-0.5 text-xs' 
        : 'px-2 py-1 text-xs';
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-md font-medium {$sizeClasses} {$statusColors[$status]}"]) }}>
    {{ $slot->isEmpty() ? $status : $slot }}
</span> 