<x-layout.app>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('admin.edit_translations', ['file' => $file, 'language' => $languages[$locale]['english']]) }}
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

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <form action="{{ route('admin.translations.update', [$locale, $file]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="flex justify-between mb-4">
                            <h3 class="text-lg font-medium">
                                {{ $file }}.php 
                                <span class="text-sm text-gray-500 dark:text-gray-400">{{ count($translations) }} {{ __('admin.translations') }}</span>
                            </h3>
                            <x-ui.button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('admin.save_translations') }}
                            </x-ui.button>
                        </div>

                        <div class="overflow-x-auto">
                            <x-data.table class="min-w-full bg-white dark:bg-gray-700 rounded-lg overflow-hidden">
                                <thead class="bg-gray-100 dark:bg-gray-600 text-gray-900 dark:text-gray-100">
                                    <tr>
                                        <x-data.table.heading class="py-3 px-4 text-left w-1/3">{{ __('admin.translation_key') }}</x-data.table.heading>
                                        @if ($locale !== 'en' && !empty($referenceTranslations))
                                            <x-data.table.heading class="py-3 px-4 text-left w-1/3">{{ __('admin.english_text') }}</x-data.table.heading>
                                        @endif
                                        <x-data.table.heading class="py-3 px-4 text-left">{{ __('admin.translation_text') }}</x-data.table.heading>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                    @forelse ($translations as $key => $value)
                                        <x-data.table.row class="hover:bg-gray-50 dark:hover:bg-gray-650">
                                            <x-data.table.cell class="py-3 px-4 align-top">
                                                <code class="bg-gray-100 dark:bg-gray-700 px-1 py-0.5 rounded text-sm">{{ $key }}</code>
                                            </x-data.table.cell>
                                            @if ($locale !== 'en' && !empty($referenceTranslations))
                                                <x-data.table.cell class="py-3 px-4 align-top text-gray-500 dark:text-gray-400">
                                                    {{ $referenceTranslations[$key] ?? '' }}
                                                </x-data.table.cell>
                                            @endif
                                            <x-data.table.cell class="py-3 px-4 align-top">
                                                @if (is_string($value))
                                                    <x-input.textarea name="translations[{{ $key }}]" rows="{{ substr_count($value, '\n') + 1 }}" class="w-full border rounded-md p-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">{{ $value }}</x-input.textarea>
                                                @else
                                                    <div class="text-yellow-600 dark:text-yellow-400">
                                                        <p>{{ __('admin.non_string_value') }}</p>
                                                        <code class="block bg-gray-100 dark:bg-gray-700 p-2 rounded text-sm">{{ var_export($value, true) }}</code>
                                                    </div>
                                                @endif
                                            </x-data.table.cell>
                                        </x-data.table.row>
                                    @empty
                                        <x-data.table.row>
                                            <x-data.table.cell colspan="{{ $locale !== 'en' && !empty($referenceTranslations) ? 3 : 2 }}" class="py-4 px-4 text-center text-gray-500 dark:text-gray-400">
                                                {{ __('admin.no_translations_found') }}
                                            </x-data.table.cell>
                                        </x-data.table.row>
                                    @endforelse
                                </tbody>
                            </x-data.table>
                        </div>

                        <div class="mt-6 text-right">
                            <x-ui.button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('admin.save_translations') }}
                            </x-ui.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout.app> 