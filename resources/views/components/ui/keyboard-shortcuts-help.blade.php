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
            class="inline-block transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left align-bottom shadow-xl transition-all dark:bg-gray-800 sm:my-8 sm:max-w-lg sm:p-6 sm:align-middle"
        >
            <div class="absolute top-0 right-0 hidden pt-4 pr-4 sm:block">
                <button type="button" x-on:click="isOpen = false" class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 dark:bg-gray-800 dark:text-gray-500 dark:hover:text-gray-400 dark:focus:ring-offset-gray-800">
                    <span class="sr-only">{{ __('shortcuts.modal_close') }}</span>
                    <x-ui.icon icon="heroicon-o-x-mark" class="h-6 w-6" aria-hidden="true" />
                </button>
            </div>
            <div>
                <h3 class="text-xl font-bold leading-6 text-gray-900 dark:text-white">{{ __('shortcuts.modal_title') }}</h3>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ __('shortcuts.modal_description') }}</p>
                
                <div class="mt-6">
                    <div class="space-y-4">
                        <!-- Navigation Shortcuts -->
                        <div>
                            <h4 class="font-medium text-gray-900 dark:text-gray-100 text-lg mb-2">{{ __('shortcuts.nav_heading') }}</h4>
                            <div class="grid grid-cols-2 gap-y-2 text-sm">
                                <div class="col-span-1 flex items-center">
                                    <kbd class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded shadow mr-2">g</kbd>
                                    <kbd class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded shadow mr-2">h</kbd>
                                    <span class="text-gray-700 dark:text-gray-300">{{ __('shortcuts.nav_homepage') }}</span>
                                </div>
                                <div class="col-span-1 flex items-center">
                                    <kbd class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded shadow mr-2">g</kbd>
                                    <kbd class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded shadow mr-2">t</kbd>
                                    <span class="text-gray-700 dark:text-gray-300">{{ __('shortcuts.nav_todos') }}</span>
                                </div>
                                <div class="col-span-1 flex items-center">
                                    <kbd class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded shadow mr-2">g</kbd>
                                    <kbd class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded shadow mr-2">?</kbd>
                                    <span class="text-gray-700 dark:text-gray-300">{{ __('shortcuts.nav_help') }}</span>
                                </div>
                                <div class="col-span-1 flex items-center">
                                    <kbd class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded shadow mr-2">?</kbd>
                                    <span class="text-gray-700 dark:text-gray-300">{{ __('shortcuts.nav_show_help') }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Todo Actions Shortcuts -->
                        <div>
                            <h4 class="font-medium text-gray-900 dark:text-gray-100 text-lg mb-2">{{ __('shortcuts.todo_heading') }}</h4>
                            <div class="grid grid-cols-2 gap-y-2 text-sm">
                                <div class="col-span-1 flex items-center">
                                    <kbd class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded shadow mr-2">n</kbd>
                                    <span class="text-gray-700 dark:text-gray-300">{{ __('shortcuts.todo_new') }}</span>
                                </div>
                                <div class="col-span-1 flex items-center">
                                    <kbd class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded shadow mr-2">f</kbd>
                                    <span class="text-gray-700 dark:text-gray-300">{{ __('shortcuts.todo_focus_search') }}</span>
                                </div>
                                <div class="col-span-1 flex items-center">
                                    <kbd class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded shadow mr-2">1</kbd>
                                    <span class="text-gray-700 dark:text-gray-300">{{ __('shortcuts.todo_filter_low') }}</span>
                                </div>
                                <div class="col-span-1 flex items-center">
                                    <kbd class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded shadow mr-2">2</kbd>
                                    <span class="text-gray-700 dark:text-gray-300">{{ __('shortcuts.todo_filter_medium') }}</span>
                                </div>
                                <div class="col-span-1 flex items-center">
                                    <kbd class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded shadow mr-2">3</kbd>
                                    <span class="text-gray-700 dark:text-gray-300">{{ __('shortcuts.todo_filter_high') }}</span>
                                </div>
                                <div class="col-span-1 flex items-center">
                                    <kbd class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded shadow mr-2">c</kbd>
                                    <span class="text-gray-700 dark:text-gray-300">{{ __('shortcuts.todo_filter_completed') }}</span>
                                </div>
                                <div class="col-span-1 flex items-center">
                                    <kbd class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded shadow mr-2">p</kbd>
                                    <span class="text-gray-700 dark:text-gray-300">{{ __('shortcuts.todo_filter_pending') }}</span>
                                </div>
                                <div class="col-span-1 flex items-center">
                                    <kbd class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded shadow mr-2">Esc</kbd>
                                    <span class="text-gray-700 dark:text-gray-300">{{ __('shortcuts.todo_close_reset') }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Text Size Shortcuts -->
                        <div>
                            <h4 class="font-medium text-gray-900 dark:text-gray-100 text-lg mb-2">{{ __('shortcuts.text_size_heading') }}</h4>
                            <div class="grid grid-cols-2 gap-y-2 text-sm">
                                <div class="col-span-1 flex items-center">
                                    <kbd class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded shadow mr-2">1</kbd>
                                    <span class="text-gray-700 dark:text-gray-300">{{ __('shortcuts.text_size_small') }}</span>
                                </div>
                                <div class="col-span-1 flex items-center">
                                    <kbd class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded shadow mr-2">2</kbd>
                                    <span class="text-gray-700 dark:text-gray-300">{{ __('shortcuts.text_size_medium') }}</span>
                                </div>
                                <div class="col-span-1 flex items-center">
                                    <kbd class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded shadow mr-2">3</kbd>
                                    <span class="text-gray-700 dark:text-gray-300">{{ __('shortcuts.text_size_large') }}</span>
                                </div>
                                <div class="col-span-1 flex items-center">
                                    <kbd class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded shadow mr-2">t</kbd>
                                    <kbd class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded shadow mr-2">s</kbd>
                                    <span class="text-gray-700 dark:text-gray-300">{{ __('shortcuts.text_size_open_menu') }}</span>
                                </div>
                                <div class="col-span-1 flex items-center">
                                    <kbd class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded shadow mr-2">0</kbd>
                                    <span class="text-gray-700 dark:text-gray-300">{{ __('shortcuts.text_size_reset') }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- General Shortcuts -->
                        <div>
                            <h4 class="font-medium text-gray-900 dark:text-gray-100 text-lg mb-2">{{ __('shortcuts.general_heading') }}</h4>
                            <div class="grid grid-cols-2 gap-y-2 text-sm">
                                <div class="col-span-1 flex items-center">
                                    <kbd class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded shadow mr-2">d</kbd>
                                    <span class="text-gray-700 dark:text-gray-300">{{ __('shortcuts.general_dark_mode') }}</span>
                                </div>
                                <div class="col-span-1 flex items-center">
                                    <kbd class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded shadow mr-2">Ctrl</kbd>
                                    <kbd class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded shadow mr-2">s</kbd>
                                    <span class="text-gray-700 dark:text-gray-300">{{ __('shortcuts.general_save') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 flex items-center justify-center">
                    <x-ui.button type="button" x-on:click="isOpen = false" variant="secondary" size="lg">
                        {{ __('shortcuts.close_button') }}
                    </x-ui.button>
                </div>
            </div>
        </div>
    </div>
</div> 