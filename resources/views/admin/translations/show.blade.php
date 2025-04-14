<x-layout.app :title="__('admin.translations.edit_locale_page_title', ['locale' => $locale])">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-6">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                 {{ __('admin.translations.editing_locale_heading', ['locale' => $locale, 'name' => Lang::get('common.language_name', [], $locale)]) }}
            </h2>
             <div class="flex items-center gap-2">
                 {{-- Add New File Form --}}
                 <form action="{{ route('admin.translations.file.store', $locale) }}" method="POST" class="flex items-center gap-2">
                     @csrf
                    <x-input.input type="text" name="filename" placeholder="{{ __('admin.translations.new_file_placeholder') }}" required pattern="^[a-zA-Z0-9_\-]+$" title="{{ __('admin.translations.new_file_title') }}" />
                     <x-ui.button type="submit" variant="secondary" size="sm">{{ __('admin.translations.add_file_button') }}</x-ui.button>
                     @error('filename')
                         <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                     @enderror
                 </form>
                <x-ui.button href="{{ route('admin.translations.index') }}" variant="secondary" size="sm" icon="heroicon-s-arrow-left">
                    {{ __('admin.translations.back_to_list') }}
                 </x-ui.button>
             </div>
        </div>

        <x-feedback.alert-messages />

         @if(empty($files))
            <x-ui.card withBorder>
                 <x-ui.empty-state 
                    icon="heroicon-o-document-minus" 
                    title="{{ __('admin.translations.no_files_title') }}"
                    description="{{ __('admin.translations.no_files_desc') }}"
                />
            </x-ui.card>
        @else
             @foreach($files as $filename => $content)
                <x-ui.card withBorder class="mb-6">
                     <form action="{{ route('admin.translations.update', [$locale, $filename]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="flex justify-between items-center mb-4">
                             <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $filename }}.php</h3>
                             <div class="flex space-x-2">
                                <x-ui.button type="submit" variant="primary" size="sm">{{ __('admin.translations.save_file_button') }}</x-ui.button>
                                <x-ui.button 
                                    type="button" 
                                    onclick="if(confirm('{{ __('admin.translations.delete_file_confirm', ['file' => $filename]) }}')) { document.getElementById('delete-form-{{ $locale }}-{{ $filename }}').submit(); }" 
                                    class="{{ config('styles.button.danger.sm') }}"
                                >
                                    {{ __('admin.translations.delete_button') }}
                                </x-ui.button>
                             </div>
                        </div>

                        {{-- Key Management Interface --}}
                        @php
                            try {
                                $arrayContent = eval('?>' . $content);
                                $isValidArray = is_array($arrayContent);
                            } catch (\Throwable $e) {
                                $isValidArray = false;
                            }
                        @endphp

                        @if($isValidArray)
                            <div class="mb-4 border rounded-md dark:border-gray-700 overflow-hidden">
                                <x-data.table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-800">
                                        <tr>
                                            <x-data.table.heading scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('admin.translations.key') }}</x-data.table.heading>
                                            <x-data.table.heading scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('admin.translations.value') }}</x-data.table.heading>
                                            <x-data.table.heading scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('admin.translations.actions') }}</x-data.table.heading>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                                        @forelse($arrayContent as $key => $value)
                                            <x-data.table.row>
                                                <x-data.table.cell class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $key }}</x-data.table.cell>
                                                <x-data.table.cell class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                                    @if(is_string($value))
                                                        {{ mb_strlen($value) > 50 ? mb_substr($value, 0, 50) . '...' : $value }}
                                                    @elseif(is_array($value))
                                                        <span class="text-yellow-600 dark:text-yellow-400">[{{ __('admin.translations.nested_array') }}]</span>
                                                    @else
                                                        <span class="text-red-600 dark:text-red-400">[{{ gettype($value) }}]</span>
                                                    @endif
                                                </x-data.table.cell>
                                                <x-data.table.cell class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    @if(is_string($value))
                                                        <x-ui.link href="{{ route('admin.translations.key.edit', [$locale, $filename, $key]) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-200">{{ __('admin.translations.edit_key') }}</x-ui.link>
                                                    @else
                                                        <span class="text-gray-400 dark:text-gray-600 cursor-not-allowed">{{ __('admin.translations.edit_key') }}</span>
                                                    @endif
                                                </x-data.table.cell>
                                            </x-data.table.row>
                                        @empty
                                            <x-data.table.row>
                                                <x-data.table.cell colspan="3" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">{{ __('admin.translations.no_translations') }}</x-data.table.cell>
                                            </x-data.table.row>
                                        @endforelse
                                    </tbody>
                                </x-data.table>
                            </div>
                        @endif

                        {{-- Basic Textarea for editing - REPLACE with code editor in production --}}
                        <x-input.textarea 
                            name="content" 
                            rows="15" 
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 font-mono text-sm"
                            spellcheck="false"
                        >{{ old('content', $content) }}</x-input.textarea>
                        @error('content')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </form>
                    {{-- Hidden form for delete button --}}
                    <form id="delete-form-{{ $locale }}-{{ $filename }}" action="{{ route('admin.translations.file.destroy', [$locale, $filename]) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </x-ui.card>
            @endforeach
        @endif
    </div>
</x-layout.app> 