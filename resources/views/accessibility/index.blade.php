<x-layout.app>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                {{ __('accessibility_page.title') }}
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-300">
                {{ __('accessibility_page.subtitle') }}
            </p>
        </div>

        <div class="space-y-8">
            <!-- Introduction -->
            <section class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <p class="mb-4">
                    {{ __('accessibility_page.introduction_text1') }}
                </p>
                <p>
                    {{ __('accessibility_page.introduction_text2') }}
                </p>
            </section>

            <!-- Text Size Controls -->
            <section class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="bg-indigo-600 px-6 py-4">
                    <h2 class="text-2xl font-bold text-white">{{ __('accessibility_page.text_size_title') }}</h2>
                </div>
                <div class="p-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mt-1 mr-4">
                            <x-ui.icon icon="heroicon-o-text-size" class="w-8 h-8 text-indigo-500" />
                        </div>
                        <div class="flex-1">
                            <p class="mb-4">{{ __('accessibility_page.text_size_description') }}</p>
                            
                            <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <p class="text-sm mb-2">{{ __('accessibility_page.small') }}</p>
                                    <div class="text-size-small">
                                        <p class="font-medium">{{ __('accessibility_page.sample_text') }}</p>
                                        <p>{{ __('accessibility_page.small_text_sample') }}</p>
                                    </div>
                                </div>
                                <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <p class="text-sm mb-2">{{ __('accessibility_page.medium') }}</p>
                                    <div class="text-size-medium">
                                        <p class="font-medium">{{ __('accessibility_page.sample_text') }}</p>
                                        <p>{{ __('accessibility_page.medium_text_sample') }}</p>
                                    </div>
                                </div>
                                <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <p class="text-sm mb-2">{{ __('accessibility_page.large') }}</p>
                                    <div class="text-size-large">
                                        <p class="font-medium">{{ __('accessibility_page.sample_text') }}</p>
                                        <p>{{ __('accessibility_page.large_text_sample') }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-indigo-50 dark:bg-indigo-900/30 p-4 rounded-lg">
                                <h3 class="font-semibold text-lg mb-2">{{ __('accessibility_page.how_to_change_text_size') }}</h3>
                                <ol class="list-decimal ml-5 space-y-2">
                                    <li>{{ __('accessibility_page.click_text_size_icon') }} <x-ui.icon icon="heroicon-o-text-size" class="inline-block w-5 h-5" /> {{ __('accessibility_page.in_navigation_bar') }}</li>
                                    <li>{{ __('accessibility_page.select_preferred_size') }}</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- High Contrast Mode -->
            <section class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="bg-purple-600 px-6 py-4">
                    <h2 class="text-2xl font-bold text-white">{{ __('accessibility_page.high_contrast_title') }}</h2>
                </div>
                <div class="p-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mt-1 mr-4">
                            <x-ui.icon icon="heroicon-o-eye" class="w-8 h-8 text-purple-500" />
                        </div>
                        <div class="flex-1">
                            <p class="mb-4">{{ __('accessibility_page.high_contrast_description') }}</p>
                            
                            <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <h4 class="font-medium mb-2 text-center">{{ __('accessibility_page.standard_mode') }}</h4>
                                    <div class="border border-gray-200 dark:border-gray-600 rounded p-3">
                                        <div class="mb-2 p-2 bg-blue-100 dark:bg-blue-900 rounded">
                                            <p class="text-blue-800 dark:text-blue-200">{{ __('accessibility_page.information_message') }}</p>
                                        </div>
                                        <div class="mb-2 p-2 bg-green-100 dark:bg-green-900 rounded">
                                            <p class="text-green-800 dark:text-green-200">{{ __('accessibility_page.success_message') }}</p>
                                        </div>
                                        <div class="p-2 bg-red-100 dark:bg-red-900 rounded">
                                            <p class="text-red-800 dark:text-red-200">{{ __('accessibility_page.error_message') }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg high-contrast-mode">
                                    <h4 class="font-medium mb-2 text-center">{{ __('accessibility_page.high_contrast_mode') }}</h4>
                                    <div class="border border-gray-900 rounded p-3">
                                        <div class="mb-2 p-2 bg-blue-800 rounded">
                                            <p class="text-white">{{ __('accessibility_page.information_message') }}</p>
                                        </div>
                                        <div class="mb-2 p-2 bg-green-800 rounded">
                                            <p class="text-white">{{ __('accessibility_page.success_message') }}</p>
                                        </div>
                                        <div class="p-2 bg-red-800 rounded">
                                            <p class="text-white">{{ __('accessibility_page.error_message') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-purple-50 dark:bg-purple-900/30 p-4 rounded-lg">
                                <h3 class="font-semibold text-lg mb-2">{{ __('accessibility_page.how_to_enable_high_contrast') }}</h3>
                                <div class="space-y-2">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 mr-2">
                                            <x-ui.icon icon="heroicon-o-cursor-arrow-rays" class="w-5 h-5" />
                                        </div>
                                        <p>{{ __('accessibility_page.click_high_contrast_toggle') }}</p>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 mr-2">
                                            <x-ui.icon icon="heroicon-o-keyboard" class="w-5 h-5" />
                                        </div>
                                        <p>{{ __('accessibility_page.or_use_keyboard_shortcut') }}<kbd class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded text-sm">Alt+H</kbd></p>
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
                    <h2 class="text-2xl font-bold text-white">{{ __('accessibility_page.keyboard_navigation_title') }}</h2>
                </div>
                <div class="p-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mt-1 mr-4">
                            <x-ui.icon icon="heroicon-o-keyboard" class="w-8 h-8 text-blue-500" />
                        </div>
                        <div class="flex-1">
                            <p class="mb-4">{{ __('accessibility_page.keyboard_navigation_description') }}</p>
                            
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-6">
                                <h3 class="font-semibold text-lg mb-3">{{ __('accessibility_page.common_keyboard_shortcuts') }}</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="flex items-center">
                                        <kbd class="min-w-[40px] text-center px-2 py-1 bg-gray-200 dark:bg-gray-600 rounded text-sm mr-3">Tab</kbd>
                                        <p>{{ __('accessibility_page.move_to_next') }}</p>
                                    </div>
                                    <div class="flex items-center">
                                        <kbd class="min-w-[80px] text-center px-2 py-1 bg-gray-200 dark:bg-gray-600 rounded text-sm mr-3">Shift+Tab</kbd>
                                        <p>{{ __('accessibility_page.move_to_previous') }}</p>
                                    </div>
                                    <div class="flex items-center">
                                        <kbd class="min-w-[40px] text-center px-2 py-1 bg-gray-200 dark:bg-gray-600 rounded text-sm mr-3">Enter</kbd>
                                        <p>{{ __('accessibility_page.activate_selected') }}</p>
                                    </div>
                                    <div class="flex items-center">
                                        <kbd class="min-w-[60px] text-center px-2 py-1 bg-gray-200 dark:bg-gray-600 rounded text-sm mr-3">Space</kbd>
                                        <p>{{ __('accessibility_page.toggle_checkboxes') }}</p>
                                    </div>
                                    <div class="flex items-center">
                                        <kbd class="min-w-[40px] text-center px-2 py-1 bg-gray-200 dark:bg-gray-600 rounded text-sm mr-3">Esc</kbd>
                                        <p>{{ __('accessibility_page.close_dialogs') }}</p>
                                    </div>
                                    <div class="flex items-center">
                                        <kbd class="min-w-[60px] text-center px-2 py-1 bg-gray-200 dark:bg-gray-600 rounded text-sm mr-3">Alt+H</kbd>
                                        <p>{{ __('accessibility_page.toggle_high_contrast') }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-blue-50 dark:bg-blue-900/30 p-4 rounded-lg">
                                <div class="flex items-center mb-2">
                                    <x-ui.icon icon="heroicon-o-light-bulb" class="w-5 h-5 mr-2 text-blue-500" />
                                    <h3 class="font-semibold text-lg">{{ __('accessibility_page.focus_indicators') }}</h3>
                                </div>
                                <p>{{ __('accessibility_page.focus_indicators_description') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Screen Reader Support -->
            <section class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="bg-green-600 px-6 py-4">
                    <h2 class="text-2xl font-bold text-white">{{ __('accessibility_page.screen_reader_title') }}</h2>
                </div>
                <div class="p-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mt-1 mr-4">
                            <x-ui.icon icon="heroicon-o-speaker-wave" class="w-8 h-8 text-green-500" />
                        </div>
                        <div class="flex-1">
                            <p class="mb-4">{{ __('accessibility_page.screen_reader_description') }}</p>
                            
                            <div class="space-y-6">
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <h3 class="font-semibold text-lg mb-2">{{ __('accessibility_page.features_for_screen_readers') }}</h3>
                                    <ul class="list-disc ml-5 space-y-2">
                                        <li>{{ __('accessibility_page.semantic_html') }}</li>
                                        <li>{{ __('accessibility_page.proper_heading') }}</li>
                                        <li>{{ __('accessibility_page.aria_labels') }}</li>
                                        <li>{{ __('accessibility_page.alt_text') }}</li>
                                        <li>{{ __('accessibility_page.status_announcements') }}</li>
                                        <li>{{ __('accessibility_page.skip_navigation') }}</li>
                                    </ul>
                                </div>
                                
                                <div class="bg-green-50 dark:bg-green-900/30 p-4 rounded-lg">
                                    <div class="flex items-center mb-2">
                                        <x-ui.icon icon="heroicon-o-light-bulb" class="w-5 h-5 mr-2 text-green-500" />
                                        <h3 class="font-semibold text-lg">{{ __('accessibility_page.automatic_announcements') }}</h3>
                                    </div>
                                    <p>{{ __('accessibility_page.announcements_description') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Additional Resources -->
            <section class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold mb-4">{{ __('accessibility_page.additional_resources') }}</h2>
                <div class="space-y-4">
                    <div>
                        <h3 class="font-medium text-lg">{{ __('accessibility_page.need_more_help') }}</h3>
                        <p>{{ __('accessibility_page.visit_our') }} <a href="{{ route('help') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 underline">{{ __('accessibility_page.help_center') }}</a> {{ __('accessibility_page.or_contact') }} <a href="mailto:support@example.com" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 underline">support@example.com</a>.</p>
                    </div>
                    
                    <div>
                        <h3 class="font-medium text-lg">{{ __('accessibility_page.accessibility_statement_title') }}</h3>
                        <p>{{ __('accessibility_page.accessibility_statement') }}</p>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-layout.app> 