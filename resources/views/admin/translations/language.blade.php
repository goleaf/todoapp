<x-layout.app>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('admin.language_translations', ['language' => $languages[$locale]['english']]) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <x-ui.link href="{{ route('admin.translations.index') }}" class="text-blue-500 hover:underline mb-4 inline-block">
                                &larr; {{ __('admin.back_to_languages') }}
                            </x-ui.link>
                            <h3 class="text-lg font-medium mt-2">
                                {{ $languages[$locale]['native'] }} ({{ $locale }})
                                <span class="text-sm text-gray-500 dark:text-gray-400">{{ count($files) }} {{ __('admin.files') }}</span>
                            </h3>
                        </div>
                        <x-ui.link href="{{ route('admin.translations.create-file', $locale) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('admin.add_translation_file') }}
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

                    @if (count($files) > 0)
                        <div class="overflow-x-auto">
                            <x-data.table class="min-w-full bg-white dark:bg-gray-700 rounded-lg overflow-hidden">
                                <thead class="bg-gray-100 dark:bg-gray-600 text-gray-900 dark:text-gray-100">
                                    <tr>
                                        <x-data.table.heading class="py-3 px-4 text-left">{{ __('admin.file_name') }}</x-data.table.heading>
                                        <x-data.table.heading class="py-3 px-4 text-right">{{ __('admin.actions') }}</x-data.table.heading>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                    @foreach ($files as $file)
                                        <x-data.table.row class="hover:bg-gray-50 dark:hover:bg-gray-650">
                                            <x-data.table.cell class="py-3 px-4">{{ $file }}.php</x-data.table.cell>
                                            <x-data.table.cell class="py-3 px-4 text-right">
                                                <x-ui.link href="{{ route('admin.translations.edit', [$locale, $file]) }}" class="text-blue-500 hover:text-blue-700 mr-2">
                                                    {{ __('admin.edit') }}
                                                </x-ui.link>
                                                <form action="{{ route('admin.translations.destroy-file', [$locale, $file]) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-ui.button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('{{ __('admin.confirm_delete_file') }}')">
                                                        {{ __('admin.delete') }}
                                                    </x-ui.button>
                                                </form>
                                            </x-data.table.cell>
                                        </x-data.table.row>
                                    @endforeach
                                </tbody>
                            </x-data.table>
                        </div>
                    @else
                        <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-md">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">{{ __('admin.no_translation_files') }}</h3>
                                    <p class="mt-2 text-sm text-blue-700 dark:text-blue-300">{{ __('admin.no_translation_files_description') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layout.app> 