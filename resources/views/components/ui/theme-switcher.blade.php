@props(['position' => 'dropdown'])

















<div x-data="{ 
    open: false,
    theme: localStorage.getItem('colorTheme') || 'default',
    setTheme(newTheme) {
        this.theme = newTheme;
        localStorage.setItem('colorTheme', newTheme);
        
        // Remove all theme classes
        document.documentElement.classList.remove(
            'theme-default', 
            'theme-blue', 
            'theme-green', 
            'theme-purple', 
            'theme-warm'
        );
        
        // Add the new theme class
        document.documentElement.classList.add(`theme-${newTheme}`);
        
        // Announce theme change to screen readers
        this.announceThemeChange(newTheme);
        
        // Close the dropdown
        this.open = false;
    },
    announceThemeChange(theme) {
        const announcer = document.querySelector('[aria-live="polite"]');
        if (announcer) {
            announcer.textContent = `Theme changed to ${theme}`;
        }
    },
    init() {
        // Set initial theme on page load
        this.setTheme(this.theme);
    }
}" x-init="init()">

    @if ($position === 'dropdown')
    <!-- Theme Dropdown Button -->
    <button
        @click="open = !open"
        type="button"
        class="flex items-center rounded-md py-2 px-3 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"
        id="theme-menu-button"
        aria-expanded="false"
        aria-haspopup="true"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
        </svg>
        {{ __('Theme') }}
        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
    </button>

    <!-- Theme Dropdown Menu -->
    <div 
        x-show="open" 
        @click.away="open = false"
        class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 focus:outline-none"
        role="menu"
        aria-orientation="vertical"
        aria-labelledby="theme-menu-button"
        tabindex="-1"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        style="display: none;"
    >
    @else
    <!-- Theme Options in Settings Page -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 mb-6">
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ __('Color Theme') }}</h3>
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
            {{ __('Customize the appearance of the application with different color schemes.') }}
        </p>
    @endif
    
        <div class="py-1" role="none">
            <!-- Theme Options -->
            <div class="px-4 py-2">
                <div class="grid grid-cols-1 gap-4">
                    <!-- Default Theme -->
                    <button
                        @click="setTheme('default')"
                        type="button"
                        class="flex items-center justify-between w-full px-4 py-2 text-sm rounded-md"
                        :class="{ 'bg-gray-100 dark:bg-gray-700': theme === 'default' }"
                        role="menuitem"
                        tabindex="-1"
                    >
                        <div class="flex items-center">
                            <div class="w-6 h-6 rounded-full bg-indigo-600 mr-3 ring-2 ring-white dark:ring-gray-800"></div>
                            <span>{{ __('Default (Indigo)') }}</span>
                        </div>
                        <svg x-show="theme === 'default'" class="h-5 w-5 text-indigo-600 dark:text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    
                    <!-- Blue Theme -->
                    <button
                        @click="setTheme('blue')"
                        type="button"
                        class="flex items-center justify-between w-full px-4 py-2 text-sm rounded-md"
                        :class="{ 'bg-gray-100 dark:bg-gray-700': theme === 'blue' }"
                        role="menuitem"
                        tabindex="-1"
                    >
                        <div class="flex items-center">
                            <div class="w-6 h-6 rounded-full bg-blue-600 mr-3 ring-2 ring-white dark:ring-gray-800"></div>
                            <span>{{ __('Ocean Blue') }}</span>
                        </div>
                        <svg x-show="theme === 'blue'" class="h-5 w-5 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    
                    <!-- Green Theme -->
                    <button
                        @click="setTheme('green')"
                        type="button"
                        class="flex items-center justify-between w-full px-4 py-2 text-sm rounded-md"
                        :class="{ 'bg-gray-100 dark:bg-gray-700': theme === 'green' }"
                        role="menuitem"
                        tabindex="-1"
                    >
                        <div class="flex items-center">
                            <div class="w-6 h-6 rounded-full bg-green-600 mr-3 ring-2 ring-white dark:ring-gray-800"></div>
                            <span>{{ __('Forest Green') }}</span>
                        </div>
                        <svg x-show="theme === 'green'" class="h-5 w-5 text-green-600 dark:text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    
                    <!-- Purple Theme -->
                    <button
                        @click="setTheme('purple')"
                        type="button"
                        class="flex items-center justify-between w-full px-4 py-2 text-sm rounded-md"
                        :class="{ 'bg-gray-100 dark:bg-gray-700': theme === 'purple' }"
                        role="menuitem"
                        tabindex="-1"
                    >
                        <div class="flex items-center">
                            <div class="w-6 h-6 rounded-full bg-purple-600 mr-3 ring-2 ring-white dark:ring-gray-800"></div>
                            <span>{{ __('Royal Purple') }}</span>
                        </div>
                        <svg x-show="theme === 'purple'" class="h-5 w-5 text-purple-600 dark:text-purple-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    
                    <!-- Warm Theme -->
                    <button
                        @click="setTheme('warm')"
                        type="button"
                        class="flex items-center justify-between w-full px-4 py-2 text-sm rounded-md"
                        :class="{ 'bg-gray-100 dark:bg-gray-700': theme === 'warm' }"
                        role="menuitem"
                        tabindex="-1"
                    >
                        <div class="flex items-center">
                            <div class="w-6 h-6 rounded-full bg-amber-600 mr-3 ring-2 ring-white dark:ring-gray-800"></div>
                            <span>{{ __('Warm Amber') }}</span>
                        </div>
                        <svg x-show="theme === 'warm'" class="h-5 w-5 text-amber-600 dark:text-amber-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div> 