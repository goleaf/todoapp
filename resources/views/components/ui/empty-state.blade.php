@props([

    'title' => null,
    'description' => null,
    'icon' => null,
    'iconSize' => 'xl',
    'iconClass' => 'text-gray-400 dark:text-gray-500',
    'actions' => null,
])

@php
    // Initialize required variables if they don't exist
    $attributes = $attributes ?? collect();
    $slot = $slot ?? '';
    $iconClass = $iconClass ?? '';
    
    // Get icon class from component service if not already set
    if (empty($iconClass)) {
        $iconSize = $iconSize ?? 'md';
        $iconClass = app(\App\Services\BladeComponentService::class)->getEmptyStateIconClass($iconSize);
    }
@endphp

<div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center p-10 text-center space-y-6']) }}>
    @if ($icon)
        <div class="rounded-full bg-gray-100 dark:bg-gray-800 p-3 mb-2">
            @php
                $iconSizeClass = $componentService->getEmptyStateIconClass($iconSize);
                $iconFullClass = "{$iconSizeClass} {$iconClass}";
            @endphp
            
            @icon($icon, $iconFullClass)
        </div>
    @endif
    
    @if($title)
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
            {{ $title }}
        </h3>
    @endif
    
    @if($description)
        <p class="text-gray-500 dark:text-gray-400 max-w-md">
            {{ $description }}
        </p>
    @endif
    
    @if($slot->isNotEmpty())
        <div class="text-gray-500 dark:text-gray-400 max-w-md">
            {{ $slot }}
        </div>
    @endif
    
    @if($actions)
        <div class="flex flex-wrap gap-3 justify-center mt-2">
            {{ $actions }}
        </div>
    @endif
</div> 