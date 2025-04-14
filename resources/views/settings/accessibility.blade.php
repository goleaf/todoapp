<x-layout.app>
    <x-ui.container>
        <div class="mt-8 max-w-3xl mx-auto">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">
                    {{ __('accessibility.title') }}
                </h1>
                <p class="text-gray-600 dark:text-gray-400">
                    {{ __('accessibility.description') }}
                </p>
            </div>

            <x-ui.card>
                <h2 class="text-xl font-semibold mb-6">{{ __('accessibility.display_preferences') }}</h2>

                <!-- Text Size -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium mb-3">{{ __('accessibility.text_size_title') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        {{ __('accessibility.text_size_description') }}
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
                                    <span class="font-medium">{{ __('accessibility.small') }}</span>
                                    <div class="text-size-small py-1 px-2 bg-gray-100 dark:bg-gray-600 rounded text-xs">Aa</div>
                                </div>
                                <p class="text-size-small text-left text-gray-600 dark:text-gray-400">
                                    {{ __('accessibility.small_description') }}
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
                                    <span class="font-medium">{{ __('accessibility.medium') }}</span>
                                    <div class="text-size-medium py-1 px-2 bg-gray-100 dark:bg-gray-600 rounded text-xs">Aa</div>
                                </div>
                                <p class="text-size-medium text-left text-gray-600 dark:text-gray-400">
                                    {{ __('accessibility.medium_description') }}
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
                                    <span class="font-medium">{{ __('accessibility.large') }}</span>
                                    <div class="text-size-large py-1 px-2 bg-gray-100 dark:bg-gray-600 rounded text-xs">Aa</div>
                                </div>
                                <p class="text-size-large text-left text-gray-600 dark:text-gray-400">
                                    {{ __('accessibility.large_description') }}
                                </p>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- High Contrast Mode -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium mb-3">{{ __('accessibility.contrast_title') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        {{ __('accessibility.contrast_description') }}
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
                            <span class="sr-only">{{ __('accessibility.toggle_contrast') }}</span>
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
                            {{ __('accessibility.contrast_status') }} <span x-text="highContrast ? '{{ __('accessibility.enabled') }}' : '{{ __('accessibility.disabled') }}'"></span>
                        </span>
                    </div>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        {{ __('accessibility.keyboard_shortcut') }} <kbd class="px-2 py-1 text-xs rounded bg-gray-100 dark:bg-gray-700">Alt+H</kbd>
                    </p>
                </div>
                
                <!-- Focus Indicators -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium mb-3">{{ __('accessibility.enhanced_focus') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        {{ __('accessibility.enhanced_focus_description') }}
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
                            <span class="sr-only">{{ __('accessibility.toggle_focus') }}</span>
                            <span
                                :class="{ 'translate-x-5': enhancedFocus, 'translate-x-0': !enhancedFocus }"
                                class="pointer-events-none relative inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                            ></span>
                        </button>
                        <span class="ml-3" :class="{ 'font-medium': enhancedFocus }">
                            {{ __('accessibility.focus_status') }} <span x-text="enhancedFocus ? '{{ __('accessibility.enabled') }}' : '{{ __('accessibility.disabled') }}'"></span>
                        </span>
                    </div>
                </div>

                <!-- Reduce Motion -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium mb-3">{{ __('accessibility.reduced_motion') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        {{ __('accessibility.reduced_motion_description') }}
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
                            <span class="sr-only">{{ __('accessibility.toggle_motion') }}</span>
                            <span
                                :class="{ 'translate-x-5': reduceMotion, 'translate-x-0': !reduceMotion }"
                                class="pointer-events-none relative inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                            ></span>
                        </button>
                        <span class="ml-3" :class="{ 'font-medium': reduceMotion }">
                            {{ __('accessibility.motion_status') }} <span x-text="reduceMotion ? '{{ __('accessibility.enabled') }}' : '{{ __('accessibility.disabled') }}'"></span>
                        </span>
                    </div>
                </div>
                
                <hr class="my-8 border-gray-200 dark:border-gray-700">
                
                <!-- Reset Settings -->
                <div>
                    <h3 class="text-lg font-medium mb-3">{{ __('accessibility.reset_title') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        {{ __('accessibility.reset_description') }}
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
                        {{ __('accessibility.reset_button') }}
                    </x-ui.button>
                    
                    <div class="hidden mt-3 p-3 bg-green-50 dark:bg-green-900/30 rounded-lg text-green-800 dark:text-green-200">
                        {{ __('accessibility.reset_success') }}
                    </div>
                </div>
            </x-ui.card>
            
            <div class="mt-6 text-center">
                <p class="text-gray-600 dark:text-gray-400">
                    {{ __('accessibility.learn_more') }} 
                    <a href="{{ route('help') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                        {{ __('accessibility.view_guide') }}
                    </a>
                </p>
            </div>
        </div>
    </x-ui.container>
</x-layout.app> 