<x-layout.app>
    <x-ui.container>
        <div class="mt-8 max-w-3xl mx-auto">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">
                    {{ __('Accessibility Settings') }}
                </h1>
                <p class="text-gray-600 dark:text-gray-400">
                    {{ __('Customize the app to meet your accessibility needs') }}
                </p>
            </div>

            <x-ui.card>
                <h2 class="text-xl font-semibold mb-6">{{ __('Display Preferences') }}</h2>

                <!-- Text Size -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium mb-3">{{ __('Text Size') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        {{ __('Choose your preferred text size for better readability.') }}
                    </p>
                    
                    <div class="flex flex-wrap -mx-2" x-data="{ currentSize: localStorage.getItem('textSize') || 'medium' }">
                        <div class="px-2 w-full sm:w-1/3 mb-4">
                            <button 
                                type="button" 
                                @click="localStorage.setItem('textSize', 'small'); currentSize = 'small'; window.dispatchEvent(new Event('text-size-change'))"
                                :class="{ 'ring-2 ring-indigo-500': currentSize === 'small' }"
                                class="w-full p-4 border rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            >
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-medium">{{ __('Small') }}</span>
                                    <div class="text-size-small py-1 px-2 bg-gray-100 dark:bg-gray-600 rounded text-xs">Aa</div>
                                </div>
                                <p class="text-size-small text-left text-gray-600 dark:text-gray-400">
                                    {{ __('Compact text for more content on screen.') }}
                                </p>
                            </button>
                        </div>
                        <div class="px-2 w-full sm:w-1/3 mb-4">
                            <button 
                                type="button" 
                                @click="localStorage.setItem('textSize', 'medium'); currentSize = 'medium'; window.dispatchEvent(new Event('text-size-change'))"
                                :class="{ 'ring-2 ring-indigo-500': currentSize === 'medium' }"
                                class="w-full p-4 border rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            >
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-medium">{{ __('Medium') }}</span>
                                    <div class="text-size-medium py-1 px-2 bg-gray-100 dark:bg-gray-600 rounded text-xs">Aa</div>
                                </div>
                                <p class="text-size-medium text-left text-gray-600 dark:text-gray-400">
                                    {{ __('Standard text size (default).') }}
                                </p>
                            </button>
                        </div>
                        <div class="px-2 w-full sm:w-1/3 mb-4">
                            <button 
                                type="button" 
                                @click="localStorage.setItem('textSize', 'large'); currentSize = 'large'; window.dispatchEvent(new Event('text-size-change'))"
                                :class="{ 'ring-2 ring-indigo-500': currentSize === 'large' }"
                                class="w-full p-4 border rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            >
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-medium">{{ __('Large') }}</span>
                                    <div class="text-size-large py-1 px-2 bg-gray-100 dark:bg-gray-600 rounded text-xs">Aa</div>
                                </div>
                                <p class="text-size-large text-left text-gray-600 dark:text-gray-400">
                                    {{ __('Larger text for improved readability.') }}
                                </p>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- High Contrast Mode -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium mb-3">{{ __('High Contrast Mode') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        {{ __('Toggle high contrast for better visibility.') }}
                    </p>
                    <div class="flex items-center" x-data="{ highContrast: localStorage.getItem('highContrastMode') === 'true' }">
                        <button
                            type="button"
                            @click="highContrast = !highContrast; localStorage.setItem('highContrastMode', highContrast); document.documentElement.classList.toggle('high-contrast-mode', highContrast)"
                            :class="{ 'bg-indigo-600': highContrast, 'bg-gray-200 dark:bg-gray-700': !highContrast }"
                            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                            role="switch"
                            :aria-checked="highContrast"
                        >
                            <span class="sr-only">{{ __('Toggle high contrast mode') }}</span>
                            <span
                                :class="{ 'translate-x-5': highContrast, 'translate-x-0': !highContrast }"
                                class="pointer-events-none relative inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                            >
                                <span
                                    :class="{ 'opacity-0 duration-100 ease-out': highContrast, 'opacity-100 duration-200 ease-in': !highContrast }"
                                    class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity"
                                >
                                    <x-ui.icon icon="heroicon-m-eye" class="h-3 w-3 text-gray-400" />
                                </span>
                                <span
                                    :class="{ 'opacity-100 duration-200 ease-in': highContrast, 'opacity-0 duration-100 ease-out': !highContrast }"
                                    class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity"
                                >
                                    <x-ui.icon icon="heroicon-m-eye" class="h-3 w-3 text-indigo-600" />
                                </span>
                            </span>
                        </button>
                        <span class="ml-3" :class="{ 'font-medium': highContrast }">
                            {{ __('High contrast mode is') }} <span x-text="highContrast ? '{{ __('enabled') }}' : '{{ __('disabled') }}'"></span>
                        </span>
                    </div>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        {{ __('Keyboard shortcut:') }} <kbd class="px-2 py-1 text-xs rounded bg-gray-100 dark:bg-gray-700">Alt+H</kbd>
                    </p>
                </div>
                
                <!-- Focus Indicators -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium mb-3">{{ __('Enhanced Focus Indicators') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        {{ __('Makes focus outlines more visible when navigating with a keyboard.') }}
                    </p>
                    <div class="flex items-center" x-data="{ enhancedFocus: localStorage.getItem('enhancedFocus') === 'true' }">
                        <button
                            type="button"
                            @click="enhancedFocus = !enhancedFocus; localStorage.setItem('enhancedFocus', enhancedFocus); document.documentElement.classList.toggle('enhanced-focus', enhancedFocus)"
                            :class="{ 'bg-indigo-600': enhancedFocus, 'bg-gray-200 dark:bg-gray-700': !enhancedFocus }"
                            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                            role="switch"
                            :aria-checked="enhancedFocus"
                        >
                            <span class="sr-only">{{ __('Toggle enhanced focus indicators') }}</span>
                            <span
                                :class="{ 'translate-x-5': enhancedFocus, 'translate-x-0': !enhancedFocus }"
                                class="pointer-events-none relative inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                            ></span>
                        </button>
                        <span class="ml-3" :class="{ 'font-medium': enhancedFocus }">
                            {{ __('Enhanced focus indicators are') }} <span x-text="enhancedFocus ? '{{ __('enabled') }}' : '{{ __('disabled') }}'"></span>
                        </span>
                    </div>
                </div>

                <!-- Reduce Motion -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium mb-3">{{ __('Reduce Motion') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        {{ __('Minimize animations and transitions for users sensitive to motion.') }}
                    </p>
                    <div class="flex items-center" x-data="{ reduceMotion: localStorage.getItem('reduceMotion') === 'true' }">
                        <button
                            type="button"
                            @click="reduceMotion = !reduceMotion; localStorage.setItem('reduceMotion', reduceMotion); document.documentElement.classList.toggle('reduce-motion', reduceMotion)"
                            :class="{ 'bg-indigo-600': reduceMotion, 'bg-gray-200 dark:bg-gray-700': !reduceMotion }"
                            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                            role="switch"
                            :aria-checked="reduceMotion"
                        >
                            <span class="sr-only">{{ __('Toggle reduced motion') }}</span>
                            <span
                                :class="{ 'translate-x-5': reduceMotion, 'translate-x-0': !reduceMotion }"
                                class="pointer-events-none relative inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                            ></span>
                        </button>
                        <span class="ml-3" :class="{ 'font-medium': reduceMotion }">
                            {{ __('Reduced motion is') }} <span x-text="reduceMotion ? '{{ __('enabled') }}' : '{{ __('disabled') }}'"></span>
                        </span>
                    </div>
                </div>
                
                <hr class="my-8 border-gray-200 dark:border-gray-700">
                
                <!-- Reset Settings -->
                <div>
                    <h3 class="text-lg font-medium mb-3">{{ __('Reset Accessibility Settings') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        {{ __('Return all accessibility settings to their default values.') }}
                    </p>
                    <x-ui.button 
                        variant="danger" 
                        size="lg"
                        x-data
                        @click="
                            localStorage.removeItem('textSize');
                            localStorage.removeItem('highContrastMode');
                            localStorage.removeItem('enhancedFocus');
                            localStorage.removeItem('reduceMotion');
                            document.documentElement.classList.remove('high-contrast-mode', 'enhanced-focus', 'reduce-motion');
                            document.documentElement.classList.remove('text-size-small', 'text-size-medium', 'text-size-large');
                            document.documentElement.classList.add('text-size-medium');
                            window.dispatchEvent(new Event('text-size-change'));
                            $el.nextElementSibling.classList.remove('hidden');
                            setTimeout(() => { $el.nextElementSibling.classList.add('hidden'); }, 3000);
                        "
                    >
                        {{ __('Reset to Defaults') }}
                    </x-ui.button>
                    
                    <div class="hidden mt-3 p-3 bg-green-50 dark:bg-green-900/30 rounded-lg text-green-800 dark:text-green-200">
                        <div class="flex">
                            <x-ui.icon icon="heroicon-o-check-circle" class="h-5 w-5 mr-2" />
                            <span>{{ __('Settings have been reset to their default values') }}</span>
                        </div>
                    </div>
                </div>
            </x-ui.card>
            
            <div class="mt-8 text-center">
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    {{ __('Want to learn more about our accessibility features?') }}
                </p>
                <x-ui.button variant="secondary" href="{{ route('accessibility') }}">
                    {{ __('View Accessibility Guide') }}
                </x-ui.button>
            </div>
        </div>
    </x-ui.container>
</x-layout.app> 