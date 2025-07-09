@props([

    'title' => null,
    'header' => null,
    'footer' => null,
    'headerActions' => null,
    'variant' => 'default',
    'padding' => 'default',
    'noPadding' => false,
])

@php
    // Initialize required variables if they don't exist
    $attributes = $attributes ?? collect();
    $slot = $slot ?? '';
    $baseClasses = $baseClasses ?? '';
    $contentPadding = $contentPadding ?? '';
    
    // Get attributes from component service if not already set
    if (empty($baseClasses)) {
        $params = [
            'variant' => $variant ?? 'default',
            'padding' => $padding ?? 'default',
            'noPadding' => $noPadding ?? false,
        ];
        $attrs = app(\App\Services\BladeComponentService::class)->getCardAttributes($params);
        $baseClasses = $attrs['baseClasses'];
        $contentPadding = $attrs['contentPadding'];
    }
@endphp

{{-- PHP logic moved to BladeComponentService --}}

<div {{ $attributes->merge(['class' => $baseClasses]) }}>
    @if($title || $header || $headerActions)
        <div class="{{ $contentPadding }} border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
            <div class="flex-grow">
                @if($title)
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        {{ $title }}
                    </h3>
                @endif
                
                @if($header)
                    {{ $header }}
                @endif
            </div>
            
            @if($headerActions)
                <div class="flex space-x-2">
                    {{ $headerActions }}
                </div>
            @endif
        </div>
    @endif
    
    <div class="{{ ($title || $header || $headerActions || $footer) ? $contentPadding : $contentPadding }}">
        {{ $slot }}
    </div>
    
    @if($footer)
        <div class="{{ $contentPadding }} border-t border-gray-200 dark:border-gray-700">
            {{ $footer }}
        </div>
    @endif
</div> 