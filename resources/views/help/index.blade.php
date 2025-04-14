<x-layout.app>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                {{ __('How to Use This Todo App') }}
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-300">
                {{ __('A simple guide to help you manage your tasks') }}
            </p>
        </div>

        <div class="space-y-12">
            <!-- Getting Started -->
            <section class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                <div class="bg-blue-600 px-6 py-4">
                    <h2 class="text-2xl font-bold text-white">{{ __('Getting Started') }}</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4 text-lg">
                        <p>{{ __('Welcome to your Todo App! This app helps you keep track of all your tasks in one place.') }}</p>
                        <div class="flex items-start space-x-3 p-3 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                            <span class="mt-1 text-blue-500 dark:text-blue-400">
                                <x-ui.icon icon="heroicon-o-information-circle" class="w-6 h-6" />
                            </span>
                            <p>{{ __('After logging in, you\'ll see your Todo List on the home page. This is where all your tasks will appear.') }}</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Creating a Todo -->
            <section class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                <div class="bg-green-600 px-6 py-4">
                    <h2 class="text-2xl font-bold text-white">{{ __('Creating a New Task') }}</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-6 text-lg">
                        <div class="flex flex-col space-y-2">
                            <div class="flex items-center">
                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-green-100 text-green-600 font-bold mr-3">1</span>
                                <p class="font-semibold">{{ __('Click the "Create Todo" button at the top of your list.') }}</p>
                            </div>
                            <div class="ml-11">
                                <x-ui.button icon="heroicon-o-plus" size="lg" variant="success">{{ __('Create Todo') }}</x-ui.button>
                            </div>
                        </div>

                        <div class="flex flex-col space-y-2">
                            <div class="flex items-center">
                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-green-100 text-green-600 font-bold mr-3">2</span>
                                <p class="font-semibold">{{ __('Fill in the details of your task:') }}</p>
                            </div>
                            <div class="ml-11 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <ul class="list-disc ml-5 space-y-2">
                                    <li>{{ __('Title: A short name for your task (required)') }}</li>
                                    <li>{{ __('Description: Details about what you need to do') }}</li>
                                    <li>{{ __('Due Date: When the task needs to be finished') }}</li>
                                    <li>{{ __('Priority: How important the task is (Low, Medium, High)') }}</li>
                                    <li>{{ __('Status: The current state of the task (Pending, In Progress, Completed)') }}</li>
                                    <li>{{ __('Category: Group similar tasks together') }}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="flex flex-col space-y-2">
                            <div class="flex items-center">
                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-green-100 text-green-600 font-bold mr-3">3</span>
                                <p class="font-semibold">{{ __('Click the "Save" button to create your task.') }}</p>
                            </div>
                            <div class="ml-11">
                                <x-ui.button size="lg" variant="success">{{ __('Save') }}</x-ui.button>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3 p-3 bg-green-50 dark:bg-green-900/30 rounded-lg">
                            <span class="mt-1 text-green-500 dark:text-green-400">
                                <x-ui.icon icon="heroicon-o-light-bulb" class="w-6 h-6" />
                            </span>
                            <p>{{ __('Tip: Add a due date to tasks that have a deadline so you don\'t forget them!') }}</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Managing Your Todos -->
            <section class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                <div class="bg-purple-600 px-6 py-4">
                    <h2 class="text-2xl font-bold text-white">{{ __('Managing Your Tasks') }}</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-8 text-lg">
                        <!-- Viewing Details -->
                        <div>
                            <h3 class="text-xl font-bold mb-3">{{ __('Viewing Task Details') }}</h3>
                            <div class="flex items-start space-x-3 mb-3">
                                <span class="mt-1 text-purple-500 dark:text-purple-400">
                                    <x-ui.icon icon="heroicon-o-eye" class="w-6 h-6" />
                                </span>
                                <p>{{ __('Click the "View" button on any task to see all its details.') }}</p>
                            </div>
                        </div>

                        <!-- Editing -->
                        <div>
                            <h3 class="text-xl font-bold mb-3">{{ __('Changing a Task') }}</h3>
                            <div class="flex items-start space-x-3 mb-3">
                                <span class="mt-1 text-purple-500 dark:text-purple-400">
                                    <x-ui.icon icon="heroicon-o-pencil-square" class="w-6 h-6" />
                                </span>
                                <p>{{ __('Click the "Edit" button to change any details of your task.') }}</p>
                            </div>
                        </div>

                        <!-- Completing -->
                        <div>
                            <h3 class="text-xl font-bold mb-3">{{ __('Completing a Task') }}</h3>
                            <div class="flex items-start space-x-3 mb-3">
                                <span class="mt-1 text-purple-500 dark:text-purple-400">
                                    <x-ui.icon icon="heroicon-o-check-circle" class="w-6 h-6" />
                                </span>
                                <p>{{ __('When you finish a task, edit it and change its Status to "Completed".') }}</p>
                            </div>
                            <div class="flex items-start space-x-3 p-3 bg-purple-50 dark:bg-purple-900/30 rounded-lg">
                                <span class="mt-1 text-purple-500 dark:text-purple-400">
                                    <x-ui.icon icon="heroicon-o-light-bulb" class="w-6 h-6" />
                                </span>
                                <p>{{ __('Tip: Completed tasks will be shown with a green status badge!') }}</p>
                            </div>
                        </div>

                        <!-- Deleting -->
                        <div>
                            <h3 class="text-xl font-bold mb-3">{{ __('Removing a Task') }}</h3>
                            <div class="flex items-start space-x-3 mb-3">
                                <span class="mt-1 text-red-500 dark:text-red-400">
                                    <x-ui.icon icon="heroicon-o-trash" class="w-6 h-6" />
                                </span>
                                <p>{{ __('To delete a task, click the "Delete" button. You\'ll be asked to confirm before it\'s permanently removed.') }}</p>
                            </div>
                            <div class="flex items-start space-x-3 p-3 bg-red-50 dark:bg-red-900/30 rounded-lg">
                                <span class="mt-1 text-red-500 dark:text-red-400">
                                    <x-ui.icon icon="heroicon-o-exclamation-triangle" class="w-6 h-6" />
                                </span>
                                <p>{{ __('Warning: Once deleted, a task cannot be recovered!') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Finding Tasks -->
            <section class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                <div class="bg-yellow-500 px-6 py-4">
                    <h2 class="text-2xl font-bold text-white">{{ __('Finding Your Tasks') }}</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-6 text-lg">
                        <p>{{ __('When you have many tasks, you can use these tools to find what you need:') }}</p>
                        
                        <!-- Search -->
                        <div class="flex items-start space-x-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <span class="mt-1 text-yellow-500 dark:text-yellow-400">
                                <x-ui.icon icon="heroicon-o-magnifying-glass" class="w-6 h-6" />
                            </span>
                            <div>
                                <h3 class="text-xl font-bold mb-1">{{ __('Search') }}</h3>
                                <p>{{ __('Type words in the search box to find tasks containing those words.') }}</p>
                            </div>
                        </div>
                        
                        <!-- Filter -->
                        <div class="flex items-start space-x-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <span class="mt-1 text-yellow-500 dark:text-yellow-400">
                                <x-ui.icon icon="heroicon-o-funnel" class="w-6 h-6" />
                            </span>
                            <div>
                                <h3 class="text-xl font-bold mb-1">{{ __('Filter') }}</h3>
                                <p>{{ __('Use the Filter options to show only certain types of tasks:') }}</p>
                                <ul class="list-disc ml-5 mt-2 space-y-1">
                                    <li>{{ __('By Category (work, home, etc.)') }}</li>
                                    <li>{{ __('By Status (pending, completed, etc.)') }}</li>
                                </ul>
                            </div>
                        </div>
                        
                        <!-- Sort -->
                        <div class="flex items-start space-x-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <span class="mt-1 text-yellow-500 dark:text-yellow-400">
                                <x-ui.icon icon="heroicon-o-arrows-up-down" class="w-6 h-6" />
                            </span>
                            <div>
                                <h3 class="text-xl font-bold mb-1">{{ __('Sort') }}</h3>
                                <p>{{ __('Choose how to order your tasks:') }}</p>
                                <ul class="list-disc ml-5 mt-2 space-y-1">
                                    <li>{{ __('By Date (newest or oldest first)') }}</li>
                                    <li>{{ __('By Due Date (tasks due soonest first)') }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Accessibility Features -->
            <section class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                <div class="bg-indigo-600 px-6 py-4">
                    <h2 class="text-2xl font-bold text-white">{{ __('Accessibility Features') }}</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-6 text-lg">
                        <p>{{ __('Our app includes accessibility features to help make it usable for everyone:') }}</p>
                        
                        <!-- Text Size -->
                        <div class="flex items-start space-x-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <span class="mt-1 text-indigo-500 dark:text-indigo-400">
                                <x-ui.icon icon="heroicon-o-text-size" class="w-6 h-6" />
                            </span>
                            <div>
                                <h3 class="text-xl font-bold mb-1">{{ __('Text Size Controls') }}</h3>
                                <p>{{ __('Adjust the size of text throughout the app for better readability:') }}</p>
                                <ul class="list-disc ml-5 mt-2 space-y-1">
                                    <li>{{ __('Small: For users who prefer more compact text') }}</li>
                                    <li>{{ __('Medium: Default size') }}</li>
                                    <li>{{ __('Large: For improved readability') }}</li>
                                </ul>
                                <div class="mt-3">
                                    <p class="font-semibold mb-1">{{ __('How to change text size:') }}</p>
                                    <ol class="list-decimal ml-5 space-y-1">
                                        <li>{{ __('Click on the text size icon in the navigation bar') }}</li>
                                        <li>{{ __('Select your preferred size from the dropdown menu') }}</li>
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
                                <h3 class="text-xl font-bold mb-1">{{ __('High Contrast Mode') }}</h3>
                                <p>{{ __('Improve visibility with higher contrast colors:') }}</p>
                                <div class="mt-3">
                                    <p class="font-semibold mb-1">{{ __('How to enable high contrast:') }}</p>
                                    <ol class="list-decimal ml-5 space-y-1">
                                        <li>{{ __('Click on the high contrast toggle in the navigation bar') }}</li>
                                        <li>{{ __('Or use the keyboard shortcut: Alt+H') }}</li>
                                    </ol>
                                </div>
                                <div class="flex items-start space-x-3 p-3 mt-3 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg">
                                    <span class="mt-1 text-indigo-500 dark:text-indigo-400">
                                        <x-ui.icon icon="heroicon-o-light-bulb" class="w-6 h-6" />
                                    </span>
                                    <p>{{ __('Tip: Your accessibility preferences will be remembered even after you log out!') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Keyboard Navigation -->
                        <div class="flex items-start space-x-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <span class="mt-1 text-indigo-500 dark:text-indigo-400">
                                <x-ui.icon icon="heroicon-o-keyboard" class="w-6 h-6" />
                            </span>
                            <div>
                                <h3 class="text-xl font-bold mb-1">{{ __('Keyboard Navigation') }}</h3>
                                <p>{{ __('Navigate the app using just your keyboard:') }}</p>
                                <ul class="list-disc ml-5 mt-2 space-y-1">
                                    <li>{{ __('Tab: Move between interactive elements') }}</li>
                                    <li>{{ __('Enter/Space: Activate buttons and controls') }}</li>
                                    <li>{{ __('Escape: Close dialogs and dropdowns') }}</li>
                                    <li>{{ __('Alt+H: Toggle high contrast mode') }}</li>
                                </ul>
                            </div>
                        </div>
                        
                        <!-- Screen Reader Support -->
                        <div class="flex items-start space-x-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <span class="mt-1 text-indigo-500 dark:text-indigo-400">
                                <x-ui.icon icon="heroicon-o-speaker-wave" class="w-6 h-6" />
                            </span>
                            <div>
                                <h3 class="text-xl font-bold mb-1">{{ __('Screen Reader Support') }}</h3>
                                <p>{{ __('Our app is compatible with screen readers, with features like:') }}</p>
                                <ul class="list-disc ml-5 mt-2 space-y-1">
                                    <li>{{ __('ARIA labels for all interactive elements') }}</li>
                                    <li>{{ __('Screen reader announcements for important changes') }}</li>
                                    <li>{{ __('Semantic HTML structure for better navigation') }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Getting Help -->
            <section class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                <div class="bg-red-600 px-6 py-4">
                    <h2 class="text-2xl font-bold text-white">{{ __('Need More Help?') }}</h2>
                </div>
                <div class="p-6">
                    <div class="flex items-start space-x-4 text-lg">
                        <span class="mt-1 text-red-500 dark:text-red-400">
                            <x-ui.icon icon="heroicon-o-question-mark-circle" class="w-8 h-8" />
                        </span>
                        <div>
                            <p class="mb-4">{{ __('If you need further assistance, please contact our support team:') }}</p>
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg text-center">
                                <p class="font-bold text-xl">support@todoapp.example.com</p>
                                <p class="mt-2">{{ __('or call') }}</p>
                                <p class="font-bold text-xl">1-800-TODO-HELP</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-layout.app> 