@props([
    'status' => 'default',
    'type' => 'status',
    'small' => false
])

<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-md font-medium {$sizeClasses} {$statusColors}"]) }}>
    {{ $slot->isEmpty() ? $status : $slot }}
</span> 