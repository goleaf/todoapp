@props([
    'src' => null,
    'alt' => 'Avatar',
    'size' => 'md',
    'name' => null,
    'status' => null, // null, 'online', 'away', 'busy', 'offline'
    'statusPosition' => 'bottom-right', // 'top-right', 'top-left', 'bottom-right', 'bottom-left'
    'square' => false
])

@php
    $sizeClasses = [
        'xs' => 'h-6 w-6 text-xs',
        'sm' => 'h-8 w-8 text-xs',
        'md' => 'h-10 w-10 text-sm',
        'lg' => 'h-12 w-12 text-base',
        'xl' => 'h-16 w-16 text-lg',
        '2xl' => 'h-20 w-20 text-xl',
    ];
    
    $statusSizes = [
        'xs' => 'h-1.5 w-1.5',
        'sm' => 'h-2 w-2',
        'md' => 'h-2.5 w-2.5',
        'lg' => 'h-3 w-3',
        'xl' => 'h-3.5 w-3.5',
        '2xl' => 'h-4 w-4',
    ];
    
    $statusColors = [
        'online' => 'bg-green-400',
        'away' => 'bg-yellow-400',
        'busy' => 'bg-red-400',
        'offline' => 'bg-gray-400',
    ];
    
    $statusPositions = [
        'top-right' => 'top-0 right-0 -mt-1 -mr-1',
        'top-left' => 'top-0 left-0 -mt-1 -ml-1',
        'bottom-right' => 'bottom-0 right-0 -mb-1 -mr-1',
        'bottom-left' => 'bottom-0 left-0 -mb-1 -ml-1',
    ];
    
    $borderRadius = $square ? 'rounded-md' : 'rounded-full';
    
    // Get initials if name is provided
    $initials = '';
    if ($name) {
        $words = explode(' ', $name);
        if (count($words) >= 2) {
            $initials = strtoupper(substr($words[0], 0, 1) . substr(end($words), 0, 1));
        } else {
            $initials = strtoupper(substr($name, 0, 2));
        }
    }
@endphp

<div class="relative inline-block">
    @if($src)
        <img 
            src="{{ $src }}" 
            alt="{{ $alt }}" 
            {{ $attributes->merge(['class' => $sizeClasses[$size] . ' ' . $borderRadius . ' object-cover object-center']) }}
        >
    @else
        <div {{ $attributes->merge(['class' => $sizeClasses[$size] . ' ' . $borderRadius . ' flex items-center justify-center bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300 font-medium']) }}>
            {{ $initials }}
        </div>
    @endif
    
    @if($status && isset($statusColors[$status]))
        <span class="absolute {{ $statusPositions[$statusPosition] }} {{ $statusSizes[$size] }} {{ $statusColors[$status] }} rounded-full ring-2 ring-white dark:ring-gray-800"></span>
    @endif
</div> 