@props([
    'title' => 'No data available',
    'description' => null,
    'icon' => null,
    'action' => null,
    'actionLabel' => null,
    'actionUrl' => null
])

<div {{ $attributes->merge(['class' => 'text-center px-4 py-12 sm:p-16']) }}>
    @if($icon)
        <div class="mx-auto h-12 w-12 text-gray-400">
            {{ $icon }}
        </div>
    @else
        <x-ui.icon.heroicon-o-document-text class="mx-auto h-12 w-12 text-gray-400" />
    @endif
    
    <h3 class="mt-2 text-sm font-semibold text-gray-900 dark:text-gray-100">
        {{ $title }}
    </h3>
    
    @if($description)
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            {{ $description }}
        </p>
    @endif
    
    @if($action || $slot->isNotEmpty())
        <div class="mt-6">
            @if($action)
                <a href="{{ $actionUrl }}" class="inline-flex items-center rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">
                    {{ $action }}
                </a>
            @else
                {{ $slot }}
            @endif
        </div>
    @endif
</div> 