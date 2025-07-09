<x-layout.app>
    <x-ui.container>
        <div class="mt-8 max-w-3xl mx-auto">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">
                    {{ __('appearance.title') }}
                </h1>
                <p class="text-gray-600 dark:text-gray-400">
                    {{ __('appearance.description') }}
                </p>
            </div>

            <x-ui.card>
                <h2 class="text-xl font-semibold mb-6">{{ __('appearance.theme_settings') }}</h2>

                <!-- Dark Mode -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium mb-3">{{ __('appearance.dark_mode') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        {{ __('appearance.dark_mode_description') }}
                    </p>
                    
                    <div x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }">
                        <div class="flex items-center">
                            <button
                                type="button"
                                @click="darkMode = false; localStorage.setItem('darkMode', 'false'); document.documentElement.classList.remove('dark')"
                                :class="{ 'ring-2 ring-indigo-500': !darkMode }"
                                class="relative rounded-lg border p-3 flex items-center justify-center mr-4 focus:outline-none"
                            >
                                <span class="sr-only">{{ __('appearance.use_light_mode') }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <span class="ml-2 font-medium">{{ __('appearance.light') }}</span>
                            </button>
                            
                            <button
                                type="button"
                                @click="darkMode = true; localStorage.setItem('darkMode', 'true'); document.documentElement.classList.add('dark')"
                                :class="{ 'ring-2 ring-indigo-500': darkMode }"
                                class="relative rounded-lg border p-3 flex items-center justify-center focus:outline-none"
                            >
                                <span class="sr-only">{{ __('appearance.use_dark_mode') }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                </svg>
                                <span class="ml-2 font-medium">{{ __('appearance.dark') }}</span>
                            </button>
                        </div>
                        
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            {{ __('appearance.keyboard_shortcut') }} <kbd class="px-2 py-1 text-xs rounded bg-gray-100 dark:bg-gray-700">Alt+D</kbd>
                        </p>
                    </div>
                </div>
                
                <!-- Color Theme -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium mb-3">{{ __('appearance.color_theme') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        {{ __('appearance.color_theme_description') }}
                    </p>
                    
                    <x-ui.theme-switcher position="settings" />
                </div>
            </x-ui.card>
            
            <div class="mt-8 text-center">
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    {{ __('appearance.more_personalization') }}
                </p>
                <x-ui.button variant="secondary" href="{{ route('settings.accessibility.edit') }}">
                    {{ __('appearance.accessibility_settings') }}
                </x-ui.button>
            </div>
        </div>
    </x-ui.container>
</x-layout.app> 