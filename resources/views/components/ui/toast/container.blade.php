@props(['position' => 'bottom-right'])

<div 
    x-data="Toast()"
    @toast.window="add($event.detail.message, $event.detail.options || {})"
    @toast-success.window="success($event.detail.message, $event.detail.options || {})"
    @toast-error.window="error($event.detail.message, $event.detail.options || {})"
    @toast-warning.window="warning($event.detail.message, $event.detail.options || {})"
    @toast-info.window="info($event.detail.message, $event.detail.options || {})"
    class="toast-container fixed z-50 inset-0 pointer-events-none flex flex-col p-4"
    :class="{
        'items-start justify-start': '{{ $position }}' === 'top-left',
        'items-center justify-start': '{{ $position }}' === 'top-center',
        'items-end justify-start': '{{ $position }}' === 'top-right',
        'items-start justify-end': '{{ $position }}' === 'bottom-left',
        'items-center justify-end': '{{ $position }}' === 'bottom-center',
        'items-end justify-end': '{{ $position }}' === 'bottom-right'
    }"
>
    <template x-for="toast in toasts" :key="toast.id">
        <div 
            x-show="true"
            x-transition:enter="transform ease-out duration-300 transition"
            x-transition:enter-start="translate-y-2 opacity-0"
            x-transition:enter-end="translate-y-0 opacity-100"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="w-full max-w-sm bg-white dark:bg-gray-800 shadow-lg rounded-lg pointer-events-auto border border-gray-100 dark:border-gray-700 overflow-hidden mb-3"
            :class="{
                'border-blue-300 dark:border-blue-700': toast.type === 'info',
                'border-green-300 dark:border-green-700': toast.type === 'success',
                'border-yellow-300 dark:border-yellow-700': toast.type === 'warning',
                'border-red-300 dark:border-red-700': toast.type === 'error'
            }"
        >
            <div class="p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <template x-if="toast.type === 'info'">
                            <x-ui.icon icon="heroicon-o-information-circle" class="h-6 w-6 text-blue-500 dark:text-blue-400" />
                        </template>
                        <template x-if="toast.type === 'success'">
                            <x-ui.icon icon="heroicon-o-check-circle" class="h-6 w-6 text-green-500 dark:text-green-400" />
                        </template>
                        <template x-if="toast.type === 'warning'">
                            <x-ui.icon icon="heroicon-o-exclamation-triangle" class="h-6 w-6 text-yellow-500 dark:text-yellow-400" />
                        </template>
                        <template x-if="toast.type === 'error'">
                            <x-ui.icon icon="heroicon-o-x-circle" class="h-6 w-6 text-red-500 dark:text-red-400" />
                        </template>
                    </div>
                    <div class="ml-3 w-0 flex-1">
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100" x-text="toast.message"></p>
                    </div>
                    <div class="ml-4 flex-shrink-0 flex">
                        <button 
                            type="button" 
                            class="bg-white dark:bg-gray-800 rounded-md inline-flex text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            @click="remove(toast.id)"
                        >
                            <span class="sr-only">{{ __('Close') }}</span>
                            <x-ui.icon icon="heroicon-o-x-mark" class="h-5 w-5" />
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div> 