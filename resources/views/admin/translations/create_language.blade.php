<x-layout.app>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('admin.add_new_language') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <x-ui.link href="{{ route('admin.translations.index') }}" class="text-blue-500 hover:underline">
                            &larr; {{ __('admin.back_to_languages') }}
                        </x-ui.link>
                    </div>

                    <form action="{{ route('admin.translations.store-language') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <x-input.label for="locale" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('admin.language_code') }} <span class="text-red-500">*</span>
                            </x-input.label>
                            <div class="mt-1">
                                <x-input.input type="text" name="locale" id="locale" required
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600"
                                    placeholder="en, fr, es, de, etc."
                                    maxlength="2"
                                    pattern="[a-z]{2}"
                                    title="{{ __('admin.language_code_help') }}"
                                    value="{{ old('locale') }}" />
                            </div>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('admin.language_code_help') }}
                            </p>
                            @error('locale')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <x-input.label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('admin.language_name') }} <span class="text-red-500">*</span>
                            </x-input.label>
                            <div class="mt-1">
                                <x-input.input type="text" name="name" id="name" required
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600"
                                    placeholder="English, Français, Español, etc."
                                    value="{{ old('name') }}" />
                            </div>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('admin.language_name_in_native') }}
                            </p>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-6">
                            <x-ui.button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('admin.create_language') }}
                            </x-ui.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout.app> 