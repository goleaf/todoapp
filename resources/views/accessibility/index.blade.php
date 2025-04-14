<x-layout.app>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                {{ __('Accessibility Features') }}
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-300">
                {{ __('Making our app accessible to everyone') }}
            </p>
        </div>

        <div class="space-y-8">
            <!-- Introduction -->
            <section class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <p class="mb-4">
                    {{ __('We are committed to ensuring our application is accessible to all users. This page outlines the accessibility features available and how to use them.') }}
                </p>
                <p>
                    {{ __('Our accessibility features work for both guest users and registered users. Your preferences are saved in your browser and will be remembered even after you close the site.') }}
                </p>
            </section>

            <!-- Text Size Controls -->
            <section class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="bg-indigo-600 px-6 py-4">
                    <h2 class="text-2xl font-bold text-white">{{ __('Text Size Controls') }}</h2>
                </div>
                <div class="p-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mt-1 mr-4">
                            <x-ui.icon icon="heroicon-o-text-size" class="w-8 h-8 text-indigo-500" />
                        </div>
                        <div class="flex-1">
                            <p class="mb-4">{{ __('Adjust the size of text throughout the app to suit your needs:') }}</p>
                            
                            <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <p class="text-sm mb-2">{{ __('Small') }}</p>
                                    <div class="text-size-small">
                                        <p class="font-medium">{{ __('Sample Text') }}</p>
                                        <p>{{ __('This is how small text appears.') }}</p>
                                    </div>
                                </div>
                                <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <p class="text-sm mb-2">{{ __('Medium (Default)') }}</p>
                                    <div class="text-size-medium">
                                        <p class="font-medium">{{ __('Sample Text') }}</p>
                                        <p>{{ __('This is how medium text appears.') }}</p>
                                    </div>
                                </div>
                                <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <p class="text-sm mb-2">{{ __('Large') }}</p>
                                    <div class="text-size-large">
                                        <p class="font-medium">{{ __('Sample Text') }}</p>
                                        <p>{{ __('This is how large text appears.') }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-indigo-50 dark:bg-indigo-900/30 p-4 rounded-lg">
                                <h3 class="font-semibold text-lg mb-2">{{ __('How to Change Text Size') }}</h3>
                                <ol class="list-decimal ml-5 space-y-2">
                                    <li>{{ __('Click on the text size icon') }} <x-ui.icon icon="heroicon-o-text-size" class="inline-block w-5 h-5" /> {{ __('in the navigation bar') }}</li>
                                    <li>{{ __('Select your preferred size from the dropdown menu') }}</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- High Contrast Mode -->
            <section class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="bg-purple-600 px-6 py-4">
                    <h2 class="text-2xl font-bold text-white">{{ __('High Contrast Mode') }}</h2>
                </div>
                <div class="p-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mt-1 mr-4">
                            <x-ui.icon icon="heroicon-o-eye" class="w-8 h-8 text-purple-500" />
                        </div>
                        <div class="flex-1">
                            <p class="mb-4">{{ __('High contrast mode enhances visibility by increasing the contrast between foreground and background elements. This feature is especially helpful for users with low vision or contrast sensitivity issues.') }}</p>
                            
                            <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <h4 class="font-medium mb-2 text-center">{{ __('Standard Mode') }}</h4>
                                    <div class="border border-gray-200 dark:border-gray-600 rounded p-3">
                                        <div class="mb-2 p-2 bg-blue-100 dark:bg-blue-900 rounded">
                                            <p class="text-blue-800 dark:text-blue-200">{{ __('Information Message') }}</p>
                                        </div>
                                        <div class="mb-2 p-2 bg-green-100 dark:bg-green-900 rounded">
                                            <p class="text-green-800 dark:text-green-200">{{ __('Success Message') }}</p>
                                        </div>
                                        <div class="p-2 bg-red-100 dark:bg-red-900 rounded">
                                            <p class="text-red-800 dark:text-red-200">{{ __('Error Message') }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg high-contrast-mode">
                                    <h4 class="font-medium mb-2 text-center">{{ __('High Contrast Mode') }}</h4>
                                    <div class="border border-gray-900 rounded p-3">
                                        <div class="mb-2 p-2 bg-blue-800 rounded">
                                            <p class="text-white">{{ __('Information Message') }}</p>
                                        </div>
                                        <div class="mb-2 p-2 bg-green-800 rounded">
                                            <p class="text-white">{{ __('Success Message') }}</p>
                                        </div>
                                        <div class="p-2 bg-red-800 rounded">
                                            <p class="text-white">{{ __('Error Message') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-purple-50 dark:bg-purple-900/30 p-4 rounded-lg">
                                <h3 class="font-semibold text-lg mb-2">{{ __('How to Enable High Contrast Mode') }}</h3>
                                <div class="space-y-2">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 mr-2">
                                            <x-ui.icon icon="heroicon-o-cursor-arrow-rays" class="w-5 h-5" />
                                        </div>
                                        <p>{{ __('Click the high contrast toggle in the navigation bar') }}</p>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 mr-2">
                                            <x-ui.icon icon="heroicon-o-keyboard" class="w-5 h-5" />
                                        </div>
                                        <p>{{ __('Or use the keyboard shortcut: ') }}<kbd class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded text-sm">Alt+H</kbd></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Keyboard Navigation -->
            <section class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="bg-blue-600 px-6 py-4">
                    <h2 class="text-2xl font-bold text-white">{{ __('Keyboard Navigation') }}</h2>
                </div>
                <div class="p-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mt-1 mr-4">
                            <x-ui.icon icon="heroicon-o-keyboard" class="w-8 h-8 text-blue-500" />
                        </div>
                        <div class="flex-1">
                            <p class="mb-4">{{ __('Our app is fully navigable using only a keyboard. This is essential for users who cannot use a mouse or prefer keyboard navigation.') }}</p>
                            
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-6">
                                <h3 class="font-semibold text-lg mb-3">{{ __('Common Keyboard Shortcuts') }}</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="flex items-center">
                                        <kbd class="min-w-[40px] text-center px-2 py-1 bg-gray-200 dark:bg-gray-600 rounded text-sm mr-3">Tab</kbd>
                                        <p>{{ __('Move to next interactive element') }}</p>
                                    </div>
                                    <div class="flex items-center">
                                        <kbd class="min-w-[80px] text-center px-2 py-1 bg-gray-200 dark:bg-gray-600 rounded text-sm mr-3">Shift+Tab</kbd>
                                        <p>{{ __('Move to previous interactive element') }}</p>
                                    </div>
                                    <div class="flex items-center">
                                        <kbd class="min-w-[40px] text-center px-2 py-1 bg-gray-200 dark:bg-gray-600 rounded text-sm mr-3">Enter</kbd>
                                        <p>{{ __('Activate selected button/link') }}</p>
                                    </div>
                                    <div class="flex items-center">
                                        <kbd class="min-w-[60px] text-center px-2 py-1 bg-gray-200 dark:bg-gray-600 rounded text-sm mr-3">Space</kbd>
                                        <p>{{ __('Toggle checkboxes/buttons') }}</p>
                                    </div>
                                    <div class="flex items-center">
                                        <kbd class="min-w-[40px] text-center px-2 py-1 bg-gray-200 dark:bg-gray-600 rounded text-sm mr-3">Esc</kbd>
                                        <p>{{ __('Close dialogs/menus') }}</p>
                                    </div>
                                    <div class="flex items-center">
                                        <kbd class="min-w-[60px] text-center px-2 py-1 bg-gray-200 dark:bg-gray-600 rounded text-sm mr-3">Alt+H</kbd>
                                        <p>{{ __('Toggle high contrast mode') }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-blue-50 dark:bg-blue-900/30 p-4 rounded-lg">
                                <div class="flex items-center mb-2">
                                    <x-ui.icon icon="heroicon-o-light-bulb" class="w-5 h-5 mr-2 text-blue-500" />
                                    <h3 class="font-semibold text-lg">{{ __('Focus Indicators') }}</h3>
                                </div>
                                <p>{{ __('A visible outline appears around the currently focused element, helping you keep track of your position as you navigate with a keyboard.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Screen Reader Support -->
            <section class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="bg-green-600 px-6 py-4">
                    <h2 class="text-2xl font-bold text-white">{{ __('Screen Reader Support') }}</h2>
                </div>
                <div class="p-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mt-1 mr-4">
                            <x-ui.icon icon="heroicon-o-speaker-wave" class="w-8 h-8 text-green-500" />
                        </div>
                        <div class="flex-1">
                            <p class="mb-4">{{ __('Our application is built to be compatible with screen readers, making it accessible to blind and visually impaired users.') }}</p>
                            
                            <div class="space-y-6">
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <h3 class="font-semibold text-lg mb-2">{{ __('Features for Screen Reader Users') }}</h3>
                                    <ul class="list-disc ml-5 space-y-2">
                                        <li>{{ __('Semantic HTML structure for logical navigation') }}</li>
                                        <li>{{ __('Proper heading hierarchy for easy document navigation') }}</li>
                                        <li>{{ __('ARIA labels for all interactive elements') }}</li>
                                        <li>{{ __('Descriptive alt text for all images') }}</li>
                                        <li>{{ __('Status announcements for important changes') }}</li>
                                        <li>{{ __('Skip navigation links for jumping to main content') }}</li>
                                    </ul>
                                </div>
                                
                                <div class="bg-green-50 dark:bg-green-900/30 p-4 rounded-lg">
                                    <div class="flex items-center mb-2">
                                        <x-ui.icon icon="heroicon-o-light-bulb" class="w-5 h-5 mr-2 text-green-500" />
                                        <h3 class="font-semibold text-lg">{{ __('Automatic Announcements') }}</h3>
                                    </div>
                                    <p>{{ __('Important actions, like changing settings or completing tasks, are automatically announced to screen readers.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Additional Resources -->
            <section class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold mb-4">{{ __('Additional Accessibility Resources') }}</h2>
                <div class="space-y-4">
                    <div>
                        <h3 class="font-medium text-lg">{{ __('Need More Help?') }}</h3>
                        <p>{{ __('Visit our') }} <a href="{{ route('help') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 underline">{{ __('Help Center') }}</a> {{ __('or contact our support team at') }} <a href="mailto:support@example.com" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 underline">support@example.com</a>.</p>
                    </div>
                    
                    <div>
                        <h3 class="font-medium text-lg">{{ __('Accessibility Statement') }}</h3>
                        <p>{{ __('We are committed to ensuring our website is accessible to all users regardless of ability or technology. Our goal is to meet WCAG 2.1 Level AA standards.') }}</p>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-layout.app> 