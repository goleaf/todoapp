<x-layout.app>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                {{ __('help.title') }}
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-300">
                {{ __('help.subtitle') }}
            </p>
        </div>

        <div class="space-y-12">
            <!-- Getting Started -->
            <section class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                <div class="bg-blue-600 px-6 py-4">
                    <h2 class="text-2xl font-bold text-white">{{ __('help.getting_started') }}</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4 text-lg">
                        <p>{{ __('help.welcome_message') }}</p>
                        <div class="flex items-start space-x-3 p-3 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                            <span class="mt-1 text-blue-500 dark:text-blue-400">
                                <x-ui.icon icon="heroicon-o-information-circle" class="w-6 h-6" />
                            </span>
                            <p>{{ __('help.after_login_info') }}</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Creating a Todo -->
            <section class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                <div class="bg-green-600 px-6 py-4">
                    <h2 class="text-2xl font-bold text-white">{{ __('help.creating_task') }}</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-6 text-lg">
                        <div class="flex flex-col space-y-2">
                            <div class="flex items-center">
                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-green-100 text-green-600 font-bold mr-3">1</span>
                                <p class="font-semibold">{{ __('help.create_task_step1') }}</p>
                            </div>
                            <div class="ml-11">
                                <x-ui.button icon="heroicon-o-plus" size="lg" variant="success">{{ __('help.create_task_button') }}</x-ui.button>
                            </div>
                        </div>

                        <div class="flex flex-col space-y-2">
                            <div class="flex items-center">
                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-green-100 text-green-600 font-bold mr-3">2</span>
                                <p class="font-semibold">{{ __('help.create_task_step2') }}</p>
                            </div>
                            <div class="ml-11 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <ul class="list-disc ml-5 space-y-2">
                                    <li>{{ __('help.create_task_title') }}</li>
                                    <li>{{ __('help.create_task_description') }}</li>
                                    <li>{{ __('help.create_task_due_date') }}</li>
                                    <li>{{ __('help.create_task_priority') }}</li>
                                    <li>{{ __('help.create_task_status') }}</li>
                                    <li>{{ __('help.create_task_category') }}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="flex flex-col space-y-2">
                            <div class="flex items-center">
                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-green-100 text-green-600 font-bold mr-3">3</span>
                                <p class="font-semibold">{{ __('help.create_task_step3') }}</p>
                            </div>
                            <div class="ml-11">
                                <x-ui.button size="lg" variant="success">{{ __('help.save') }}</x-ui.button>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3 p-3 bg-green-50 dark:bg-green-900/30 rounded-lg">
                            <span class="mt-1 text-green-500 dark:text-green-400">
                                <x-ui.icon icon="heroicon-o-light-bulb" class="w-6 h-6" />
                            </span>
                            <p>{{ __('help.create_task_tip') }}</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Managing Your Todos -->
            <section class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                <div class="bg-purple-600 px-6 py-4">
                    <h2 class="text-2xl font-bold text-white">{{ __('help.managing_tasks') }}</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-8 text-lg">
                        <!-- Viewing Details -->
                        <div>
                            <h3 class="text-xl font-bold mb-3">{{ __('help.view_task_details') }}</h3>
                            <div class="flex items-start space-x-3 mb-3">
                                <span class="mt-1 text-purple-500 dark:text-purple-400">
                                    <x-ui.icon icon="heroicon-o-eye" class="w-6 h-6" />
                                </span>
                                <p>{{ __('help.view_task_details_info') }}</p>
                            </div>
                        </div>

                        <!-- Editing -->
                        <div>
                            <h3 class="text-xl font-bold mb-3">{{ __('help.change_task') }}</h3>
                            <div class="flex items-start space-x-3 mb-3">
                                <span class="mt-1 text-purple-500 dark:text-purple-400">
                                    <x-ui.icon icon="heroicon-o-pencil-square" class="w-6 h-6" />
                                </span>
                                <p>{{ __('help.change_task_info') }}</p>
                            </div>
                        </div>

                        <!-- Completing -->
                        <div>
                            <h3 class="text-xl font-bold mb-3">{{ __('help.complete_task') }}</h3>
                            <div class="flex items-start space-x-3 mb-3">
                                <span class="mt-1 text-purple-500 dark:text-purple-400">
                                    <x-ui.icon icon="heroicon-o-check-circle" class="w-6 h-6" />
                                </span>
                                <p>{{ __('help.complete_task_info') }}</p>
                            </div>
                            <div class="flex items-start space-x-3 p-3 bg-purple-50 dark:bg-purple-900/30 rounded-lg">
                                <span class="mt-1 text-purple-500 dark:text-purple-400">
                                    <x-ui.icon icon="heroicon-o-light-bulb" class="w-6 h-6" />
                                </span>
                                <p>{{ __('help.complete_task_tip') }}</p>
                            </div>
                        </div>

                        <!-- Deleting -->
                        <div>
                            <h3 class="text-xl font-bold mb-3">{{ __('help.remove_task') }}</h3>
                            <div class="flex items-start space-x-3 mb-3">
                                <span class="mt-1 text-red-500 dark:text-red-400">
                                    <x-ui.icon icon="heroicon-o-trash" class="w-6 h-6" />
                                </span>
                                <p>{{ __('help.remove_task_info') }}</p>
                            </div>
                            <div class="flex items-start space-x-3 p-3 bg-red-50 dark:bg-red-900/30 rounded-lg">
                                <span class="mt-1 text-red-500 dark:text-red-400">
                                    <x-ui.icon icon="heroicon-o-exclamation-triangle" class="w-6 h-6" />
                                </span>
                                <p>{{ __('help.remove_task_warning') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Finding Tasks -->
            <section class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                <div class="bg-yellow-500 px-6 py-4">
                    <h2 class="text-2xl font-bold text-white">{{ __('help.finding_tasks') }}</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-6 text-lg">
                        <p>{{ __('help.finding_tasks_intro') }}</p>
                        
                        <!-- Search -->
                        <div class="flex items-start space-x-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <span class="mt-1 text-yellow-500 dark:text-yellow-400">
                                <x-ui.icon icon="heroicon-o-magnifying-glass" class="w-6 h-6" />
                            </span>
                            <div>
                                <h3 class="text-xl font-bold mb-1">{{ __('help.search') }}</h3>
                                <p>{{ __('help.search_description') }}</p>
                            </div>
                        </div>
                        
                        <!-- Filter -->
                        <div class="flex items-start space-x-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <span class="mt-1 text-yellow-500 dark:text-yellow-400">
                                <x-ui.icon icon="heroicon-o-funnel" class="w-6 h-6" />
                            </span>
                            <div>
                                <h3 class="text-xl font-bold mb-1">{{ __('help.filter') }}</h3>
                                <p>{{ __('help.filter_description') }}</p>
                                <ul class="list-disc ml-5 mt-2 space-y-1">
                                    <li>{{ __('help.filter_category') }}</li>
                                    <li>{{ __('help.filter_status') }}</li>
                                </ul>
                            </div>
                        </div>
                        
                        <!-- Sort -->
                        <div class="flex items-start space-x-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <span class="mt-1 text-yellow-500 dark:text-yellow-400">
                                <x-ui.icon icon="heroicon-o-arrows-up-down" class="w-6 h-6" />
                            </span>
                            <div>
                                <h3 class="text-xl font-bold mb-1">{{ __('help.sort') }}</h3>
                                <p>{{ __('help.sort_description') }}</p>
                                <ul class="list-disc ml-5 mt-2 space-y-1">
                                    <li>{{ __('help.sort_date') }}</li>
                                    <li>{{ __('help.sort_due_date') }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Accessibility Features -->
            <section class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                <div class="bg-indigo-600 px-6 py-4">
                    <h2 class="text-2xl font-bold text-white">{{ __('help.accessibility_features') }}</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-6 text-lg">
                        <p>{{ __('help.accessibility_intro') }}</p>
                        
                        <!-- Text Size -->
                        <div class="flex items-start space-x-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <span class="mt-1 text-indigo-500 dark:text-indigo-400">
                                <x-ui.icon icon="heroicon-o-text-size" class="w-6 h-6" />
                            </span>
                            <div>
                                <h3 class="text-xl font-bold mb-1">{{ __('help.text_size_controls') }}</h3>
                                <p>{{ __('help.text_size_description') }}</p>
                                <ul class="list-disc ml-5 mt-2 space-y-1">
                                    <li>{{ __('help.text_size_small') }}</li>
                                    <li>{{ __('help.text_size_medium') }}</li>
                                    <li>{{ __('help.text_size_large') }}</li>
                                </ul>
                                <div class="mt-3">
                                    <p class="font-semibold mb-1">{{ __('help.how_to_change_text_size') }}</p>
                                    <ol class="list-decimal ml-5 space-y-1">
                                        <li>{{ __('help.text_size_step1') }}</li>
                                        <li>{{ __('help.text_size_step2') }}</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        
                        <!-- High Contrast -->
                        <div class="flex items-start space-x-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <span class="mt-1 text-indigo-500 dark:text-indigo-400">
                                <x-ui.icon icon="heroicon-o-eye" class="w-6 h-6" />
                            </span>
                            <div>
                                <h3 class="text-xl font-bold mb-1">{{ __('help.high_contrast_mode') }}</h3>
                                <p>{{ __('help.high_contrast_description') }}</p>
                                <div class="mt-3">
                                    <p class="font-semibold mb-1">{{ __('help.how_to_enable_high_contrast') }}</p>
                                    <ol class="list-decimal ml-5 space-y-1">
                                        <li>{{ __('help.high_contrast_step1') }}</li>
                                        <li>{{ __('help.high_contrast_step2') }}</li>
                                    </ol>
                                </div>
                                <div class="flex items-start space-x-3 p-3 mt-3 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg">
                                    <span class="mt-1 text-indigo-500 dark:text-indigo-400">
                                        <x-ui.icon icon="heroicon-o-light-bulb" class="w-6 h-6" />
                                    </span>
                                    <p>{{ __('help.high_contrast_tip') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Keyboard Navigation -->
                        <div class="flex items-start space-x-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <span class="mt-1 text-indigo-500 dark:text-indigo-400">
                                <x-ui.icon icon="heroicon-o-keyboard" class="w-6 h-6" />
                            </span>
                            <div>
                                <h3 class="text-xl font-bold mb-1">{{ __('help.keyboard_navigation') }}</h3>
                                <p>{{ __('help.keyboard_description') }}</p>
                                <ul class="list-disc ml-5 mt-2 space-y-1">
                                    <li>{{ __('help.keyboard_tab') }}</li>
                                    <li>{{ __('help.keyboard_enter') }}</li>
                                    <li>{{ __('help.keyboard_escape') }}</li>
                                    <li>{{ __('help.keyboard_alt_h') }}</li>
                                </ul>
                            </div>
                        </div>
                        
                        <!-- Screen Reader Support -->
                        <div class="flex items-start space-x-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <span class="mt-1 text-indigo-500 dark:text-indigo-400">
                                <x-ui.icon icon="heroicon-o-speaker-wave" class="w-6 h-6" />
                            </span>
                            <div>
                                <h3 class="text-xl font-bold mb-1">{{ __('help.screen_reader') }}</h3>
                                <p>{{ __('help.screen_reader_description') }}</p>
                                <ul class="list-disc ml-5 mt-2 space-y-1">
                                    <li>{{ __('help.screen_reader_aria') }}</li>
                                    <li>{{ __('help.screen_reader_announcements') }}</li>
                                    <li>{{ __('help.screen_reader_semantic') }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Getting Help -->
            <section class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                <div class="bg-red-600 px-6 py-4">
                    <h2 class="text-2xl font-bold text-white">{{ __('help.need_help') }}</h2>
                </div>
                <div class="p-6">
                    <div class="flex items-start space-x-4 text-lg">
                        <span class="mt-1 text-red-500 dark:text-red-400">
                            <x-ui.icon icon="heroicon-o-question-mark-circle" class="w-8 h-8" />
                        </span>
                        <div>
                            <p class="mb-4">{{ __('help.need_help_info') }}</p>
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg text-center">
                                <p class="font-bold text-xl">{{ __('help.support_email') }}</p>
                                <p class="mt-2">{{ __('help.or_call') }}</p>
                                <p class="font-bold text-xl">{{ __('help.support_phone') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-layout.app> 