@props([
    'type' => 'info',
    'message' => '',
    'timeout' => 5000,
    'position' => 'bottom-right',
])

@php
    $typeClasses = [
        'info' => 'bg-blue-50 dark:bg-blue-900 text-blue-800 dark:text-blue-100 border-blue-300 dark:border-blue-700',
        'success' => 'bg-green-50 dark:bg-green-900 text-green-800 dark:text-green-100 border-green-300 dark:border-green-700',
        'warning' => 'bg-yellow-50 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-100 border-yellow-300 dark:border-yellow-700',
        'error' => 'bg-red-50 dark:bg-red-900 text-red-800 dark:text-red-100 border-red-300 dark:border-red-700',
    ];
    
    $iconClasses = [
        'info' => 'text-blue-500 dark:text-blue-400',
        'success' => 'text-green-500 dark:text-green-400',
        'warning' => 'text-yellow-500 dark:text-yellow-400',
        'error' => 'text-red-500 dark:text-red-400',
    ];
    
    $positionClasses = [
        'top-left' => 'top-4 left-4',
        'top-center' => 'top-4 left-1/2 transform -translate-x-1/2',
        'top-right' => 'top-4 right-4',
        'bottom-left' => 'bottom-4 left-4',
        'bottom-center' => 'bottom-4 left-1/2 transform -translate-x-1/2',
        'bottom-right' => 'bottom-4 right-4',
    ];
    
    $icons = [
        'info' => 'information-circle',
        'success' => 'check-circle',
        'warning' => 'exclamation',
        'error' => 'x-circle',
    ];
@endphp

<div 
    x-data="{ show: true }"
    x-init="setTimeout(() => show = false, {{ $timeout }})"
    x-show="show"
    x-transition:enter="transform ease-out duration-300 transition"
    x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
    x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
    x-transition:leave="transition ease-in duration-100"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed z-50 {{ $positionClasses[$position] }} w-full max-w-sm shadow-lg rounded-lg pointer-events-auto {{ $typeClasses[$type] }} border"
    role="alert"
>
    <div class="p-4">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <x-ui.dynamic-component :component="'ui.icon.heroicon-o-' . $icons[$type]" class="h-5 w-5 {{ $iconClasses[$type] }}" />
            </div>
            <div class="ml-3 w-0 flex-1 pt-0.5">
                <p class="text-sm font-medium">
                    {{ $message }}
                </p>
                @if($slot->isNotEmpty())
                    <div class="mt-1 text-sm">
                        {{ $slot }}
                    </div>
                @endif
            </div>
            <div class="ml-4 flex-shrink-0 flex">
                <button
                    type="button"
                    class="bg-transparent rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    x-on:click="show = false"
                >
                    <span class="sr-only">{{ __('Close') }}</span>
                    <x-ui.icon icon="heroicon-o-x-mark" class="h-5 w-5" />
                </button>
            </div>
        </div>
    </div>
</div> 