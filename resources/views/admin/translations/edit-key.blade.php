<x-layout.app>
    <x-ui.container>
        <div class="py-6">
            <div class="mb-6 flex items-center justify-between">
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
                    {{ __('admin.edit_translation_key') }}
                </h1>
                <x-ui.link href="{{ route('admin.translations.show', $locale) }}" class="flex items-center">
                    <x-ui.icon icon="heroicon-m-arrow-left" class="mr-2 h-4 w-4" />
                    {{ __('admin.back_to_translations') }}
                </x-ui.link>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <div class="mb-6">
                    <div class="flex items-center mb-2">
                        <span class="text-lg font-medium text-gray-700 dark:text-gray-300">{{ __('admin.file') }}:</span>
                        <span class="ml-2 px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded">{{ $file }}.php</span>
                    </div>
                    <div class="flex items-center mb-2">
                        <span class="text-lg font-medium text-gray-700 dark:text-gray-300">{{ __('admin.key') }}:</span>
                        <span class="ml-2 px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded">{{ $key }}</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-lg font-medium text-gray-700 dark:text-gray-300">{{ __('admin.language') }}:</span>
                        <span class="ml-2 px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded">{{ $locale }}</span>
                    </div>
                </div>

                @if($englishValue !== null)
                <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <h3 class="text-md font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('admin.english_reference') }}:</h3>
                    <div class="p-3 bg-white dark:bg-gray-800 rounded border border-gray-200 dark:border-gray-600">
                        {{ $englishValue }}
                    </div>
                </div>
                @endif

                <form action="{{ route('admin.translations.key.update', [$locale, $file, $key]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <label for="value" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('admin.translation_value') }}
                        </label>
                        <textarea 
                            id="value" 
                            name="value" 
                            rows="4" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                        >{{ old('value', $value) }}</textarea>
                        @error('value')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <x-ui.button type="submit">
                            {{ __('admin.save_translation') }}
                        </x-ui.button>
                    </div>
                </form>
            </div>
        </div>
    </x-ui.container>
</x-layout.app> 