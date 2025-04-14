@props([
    'src' => null,
    'alt' => 'Avatar',
    'size' => 'md',
    'name' => null,
    'status' => null, // null, 'online', 'away', 'busy', 'offline'
    'statusPosition' => 'bottom-right', // 'top-right', 'top-left', 'bottom-right', 'bottom-left'
    'square' => false
])

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