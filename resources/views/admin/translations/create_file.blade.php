<x-layout.app>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('admin.add_translation_file_for', ['language' => $locale]) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <x-ui.link href="{{ route('admin.translations.language', $locale) }}" class="text-blue-500 hover:underline">
                            &larr; {{ __('admin.back_to_files') }}
                        </x-ui.link>
                    </div>

                    <form action="{{ route('admin.translations.store-file', $locale) }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <x-input.label for="filename" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('admin.file_name') }} <span class="text-red-500">*</span>
                            </x-input.label>
                            <div class="mt-1">
                                <x-input.input type="text" name="filename" id="filename" required
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600"
                                    placeholder="common, auth, messages, etc."
                                    pattern="[a-zA-Z0-9_]+"
                                    title="{{ __('admin.file_name_help') }}"
                                    value="{{ old('filename') }}" />
                            </div>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('admin.file_name_help') }}
                            </p>
                            @error('filename')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-6">
                            <x-ui.button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('admin.create_file') }}
                            </x-ui.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout.app> 