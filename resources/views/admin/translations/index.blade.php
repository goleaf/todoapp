<x-layout.app>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('admin.translation_management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">{{ __('admin.available_languages') }}</h3>
                        <div class="space-x-2">
                            <form action="{{ route('admin.translations.scan') }}" method="POST" class="inline">
                                @csrf
                                <x-ui.button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    {{ __('admin.scan_for_translations') }}
                                </x-ui.button>
                            </form>
                            <x-ui.link href="{{ route('admin.translations.create-language') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('admin.add_language') }}
                            </x-ui.link>
                        </div>
                    </div>

                    <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900 rounded-lg">
                        <h4 class="font-medium mb-2">{{ __('admin.translation_guidelines') }}</h4>
                        <ul class="list-disc list-inside text-sm">
                            <li>{{ __('admin.use_flat_keys') }}</li>
                            <li>{{ __('admin.use_file_key_format') }}</li>
                            <li>{{ __('admin.scan_periodically') }}</li>
                        </ul>
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

                    @if (session('info'))
                        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('info') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <x-data.table class="min-w-full bg-white dark:bg-gray-700 rounded-lg overflow-hidden">
                            <thead class="bg-gray-100 dark:bg-gray-600 text-gray-900 dark:text-gray-100">
                                <tr>
                                    <x-data.table.heading class="py-3 px-4 text-left">{{ __('admin.language_code') }}</x-data.table.heading>
                                    <x-data.table.heading class="py-3 px-4 text-left">{{ __('admin.language_name') }}</x-data.table.heading>
                                    <x-data.table.heading class="py-3 px-4 text-right">{{ __('admin.actions') }}</x-data.table.heading>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                @foreach ($languages as $code => $names)
                                    <x-data.table.row class="hover:bg-gray-50 dark:hover:bg-gray-650">
                                        <x-data.table.cell class="py-3 px-4">{{ $code }}</x-data.table.cell>
                                        <x-data.table.cell class="py-3 px-4">
                                            <div>{{ $names['native'] }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $names['english'] }}</div>
                                        </x-data.table.cell>
                                        <x-data.table.cell class="py-3 px-4 text-right">
                                            <x-ui.link href="{{ route('admin.translations.language', $code) }}" class="text-blue-500 hover:text-blue-700 mr-2">
                                                {{ __('admin.edit') }}
                                            </x-ui.link>
                                            
                                            @if ($code !== 'en')
                                                <form action="{{ route('admin.translations.import', $code) }}" method="POST" class="inline mr-2">
                                                    @csrf
                                                    <x-ui.button type="submit" class="text-green-500 hover:text-green-700">
                                                        {{ __('admin.import_keys') }}
                                                    </x-ui.button>
                                                </form>
                                                
                                                <form action="{{ route('admin.translations.destroy-language', $code) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-ui.button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('{{ __('admin.confirm_delete_language') }}')">
                                                        {{ __('admin.delete') }}
                                                    </x-ui.button>
                                                </form>
                                            @endif
                                        </x-data.table.cell>
                                    </x-data.table.row>
                                @endforeach
                            </tbody>
                        </x-data.table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout.app> 