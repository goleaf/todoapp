@props(['position' => 'fixed'])

<div 
    x-data="{ 
        open: false,
        toggleMenu() {
            this.open = !this.open;
            if (this.open) {
                this.$nextTick(() => {
                    this.$refs.firstOption.focus();
                });
            }
        },
        closeMenu() {
            this.open = false;
        }
    }"
    @keydown.escape.prevent="closeMenu()"
    @click.away="closeMenu()"
    class="{{ $position === 'fixed' ? 'fixed bottom-4 right-4 z-50' : 'relative' }}"
>
    <!-- Accessibility Toggle Button -->
    <button
        type="button"
        @click="toggleMenu()"
        class="flex items-center justify-center w-12 h-12 rounded-full bg-indigo-600 text-white shadow-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        aria-expanded="false"
        aria-haspopup="true"
        aria-label="{{ __('Accessibility options') }}"
    >
        <span class="sr-only">{{ __('Accessibility Options') }}</span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
        </svg>
    </button>

    <!-- Accessibility Menu -->
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute right-0 bottom-16 w-56 p-3 rounded-lg bg-white dark:bg-gray-800 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
        role="menu"
        aria-orientation="vertical"
        aria-labelledby="accessibility-menu-button"
        tabindex="-1"
        style="display: none;"
    >
        <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 pb-1 border-b border-gray-200 dark:border-gray-700">
            {{ __('Accessibility Options') }}
        </p>
        
        <!-- Text Size Controls -->
        <div class="py-1 mb-2">
            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">{{ __('Text Size') }}</p>
            <div class="flex justify-between gap-1">
                <button
                    x-ref="firstOption"
                    type="button"
                    @click="$dispatch('text-size-change', 'small'); closeMenu()"
                    class="flex-1 py-1 px-2 text-xs bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 rounded-md"
                >
                    {{ __('Small') }}
                </button>
                <button
                    type="button"
                    @click="$dispatch('text-size-change', 'medium'); closeMenu()"
                    class="flex-1 py-1 px-2 text-sm bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 rounded-md"
                >
                    {{ __('Medium') }}
                </button>
                <button
                    type="button"
                    @click="$dispatch('text-size-change', 'large'); closeMenu()"
                    class="flex-1 py-1 px-2 text-base bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 rounded-md"
                >
                    {{ __('Large') }}
                </button>
            </div>
        </div>
        
        <!-- High Contrast Toggle -->
        <div class="py-1 mb-2">
            <button 
                type="button"
                @click="$dispatch('toggle-high-contrast'); closeMenu()"
                class="flex items-center w-full text-sm px-2 py-1.5 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                {{ __('High Contrast Mode') }}
                <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">(Alt+H)</span>
            </button>
        </div>
        
        <!-- Reduced Motion Toggle -->
        <div class="py-1 mb-2">
            <button 
                type="button"
                @click="$dispatch('toggle-reduced-motion'); closeMenu()"
                class="flex items-center w-full text-sm px-2 py-1.5 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                {{ __('Reduced Motion') }}
                <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">(Alt+M)</span>
            </button>
        </div>
        
        <!-- Enhanced Focus Toggle -->
        <div class="py-1 mb-2">
            <button 
                type="button"
                @click="$dispatch('toggle-enhanced-focus'); closeMenu()"
                class="flex items-center w-full text-sm px-2 py-1.5 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                {{ __('Enhanced Focus') }}
                <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">(Alt+F)</span>
            </button>
        </div>
        
        <!-- Link to Accessibility Settings -->
        <div class="py-1 pt-2 border-t border-gray-200 dark:border-gray-700">
            <a 
                href="{{ route('settings.accessibility.edit') }}"
                class="flex items-center text-sm px-2 py-1.5 text-indigo-600 dark:text-indigo-400 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                {{ __('All Accessibility Settings') }}
            </a>
        </div>
    </div>
    
    <!-- Screen reader announcer -->
    <div aria-live="polite" class="sr-only" role="status"></div>
</div> 