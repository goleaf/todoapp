@props([])

<div x-data="{ isOpen: false }" x-show="isOpen" x-on:keydown.window.escape="isOpen = false" x-on:keydown.window="handleKeyboardShortcuts($event)" @keyboard-shortcuts-help-open.window="isOpen = true" @keyboard-shortcuts-help-close.window="isOpen = false" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
    <div class="flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div
            x-show="isOpen"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
            x-on:click="isOpen = false"
            aria-hidden="true"
        ></div>

        <div
            x-show="isOpen"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="inline-block transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left align-bottom shadow-xl transition-all dark:bg-gray-800 sm:my-8 sm:max-w-md sm:p-6 sm:align-middle"
        >
            <div class="absolute top-0 right-0 hidden pt-4 pr-4 sm:block">
                <button type="button" x-on:click="isOpen = false" class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 dark:bg-gray-800 dark:text-gray-500 dark:hover:text-gray-400 dark:focus:ring-offset-gray-800">
                    <span class="sr-only">Close</span>
                    <x-ui.icon icon="phosphor-x" class="h-6 w-6" aria-hidden="true" />
                </button>
            </div>
            <div>
                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">Keyboard Shortcuts</h3>
                <div class="mt-4">
                    <div class="space-y-2">
                        <!-- Placeholder for keyboard shortcuts content -->
                        <p class="text-sm text-gray-500 dark:text-gray-300">No keyboard shortcuts are currently active.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 