@props([
    'title' => null,
    'footer' => null,
    'header' => null,
])

<div {{ $attributes->merge(['class' => 'bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden']) }}>
    @if($title || $header)
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
            @if($title)
                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">{{ $title }}</h3>
            @endif
            
            @if($header)
                {{ $header }}
            @endif
        </div>
    @endif
    
    <div class="px-4 py-5 sm:p-6">
        {{ $slot }}
    </div>
    
    @if($footer)
        <div class="px-4 py-4 sm:px-6 border-t border-gray-200 dark:border-gray-700">
            {{ $footer }}
        </div>
    @endif
</div>
