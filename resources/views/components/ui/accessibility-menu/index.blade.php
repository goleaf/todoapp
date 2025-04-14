@props(['class' => ''])

<div 
    x-data="{ open: false }" 
    class="relative {{ $class }}">
    
    <!-- Accessibility Menu Button -->
    <button
        type="button"
        class="relative p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 dark:focus:ring-offset-gray-800 focus:ring-primary-500"
        id="accessibility-menu-button"
        x-on:click="open = !open"
        x-on:mousedown.away="open = false"
        aria-expanded="false"
        aria-haspopup="true"
        aria-label="{{ __('Accessibility options') }}"
    >
        <span class="sr-only">{{ __('Open accessibility menu') }}</span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path>
            <path d="M12 16a4 4 0 1 0 0-8 4 4 0 0 0 0 8z"></path>
            <path d="M12 2v2"></path>
            <path d="M12 20v2"></path>
            <path d="M2 12h2"></path>
            <path d="M20 12h2"></path>
        </svg>
    </button>

    <!-- Accessibility Dropdown Menu -->
    <div
        x-show="open"
        x-on:keydown.escape.window="open = false"
        x-on:mousedown.away="open = false"
        class="absolute right-0 z-10 mt-2 w-64 origin-top-right rounded-md bg-white py-2 px-3 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none dark:bg-gray-800 dark:ring-gray-700"
        x-description="accessibility dropdown"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        style="display: none;"
    >
        <div class="py-1">
            <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider py-2">
                {{ __('Accessibility Options') }}
            </h3>
            
            <!-- Text Size Controls -->
            <div class="py-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    {{ __('Text Size') }}
                </label>
                <div class="flex items-center space-x-2">
                    <button
                        type="button"
                        class="px-3 py-1.5 text-xs font-medium rounded-md bg-gray-100 text-gray-800 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600"
                        x-data
                        @click="$dispatch('text-size-change', 'small')"
                    >
                        {{ __('Small') }}
                    </button>
                    <button
                        type="button"
                        class="px-3 py-1.5 text-sm font-medium rounded-md bg-gray-100 text-gray-800 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600"
                        x-data
                        @click="$dispatch('text-size-change', 'medium')"
                    >
                        {{ __('Medium') }}
                    </button>
                    <button
                        type="button"
                        class="px-3 py-1.5 text-base font-medium rounded-md bg-gray-100 text-gray-800 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600"
                        x-data
                        @click="$dispatch('text-size-change', 'large')"
                    >
                        {{ __('Large') }}
                    </button>
                </div>
            </div>
            
            <!-- High Contrast Mode Toggle -->
            <div class="py-2">
                <div class="flex items-center justify-between">
                    <label for="high-contrast-toggle-menu" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('High Contrast') }}
                    </label>
                    <button
                        id="high-contrast-toggle-menu"
                        type="button"
                        class="high-contrast-toggle relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                        aria-pressed="false"
                    >
                        <span class="sr-only">{{ __('Toggle high contrast') }}</span>
                        <span 
                            aria-hidden="true" 
                            class="high-contrast-toggle-indicator pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                        ></span>
                    </button>
                </div>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    {{ __('Keyboard shortcut: Alt+H') }}
                </p>
            </div>
        </div>
    </div>
</div> 