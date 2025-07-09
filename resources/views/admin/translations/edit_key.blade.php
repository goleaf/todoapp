<x-layout.app :title="__('admin.translations.edit_key_title', ['key' => $key, 'file' => $file])">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-6">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('admin.translations.editing_key_heading', ['key' => $key, 'file' => $file]) }}
            </h2>
            <x-ui.button href="{{ route('admin.translations.show', $locale) }}" variant="secondary" size="sm" icon="heroicon-s-arrow-left">
                {{ __('admin.translations.back_to_translations') }}
            </x-ui.button>
        </div>

        <x-feedback.alert-messages />

        <x-ui.card withBorder>
            <form action="{{ route('admin.translations.key.update', [$locale, $file, $key]) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    @foreach($translations as $langCode => $value)
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-6 last:border-b-0 last:pb-0">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2 flex items-center">
                                @php
                                    $flagMap = ['en' => '🇬🇧', 'fr' => '🇫🇷', 'es' => '🇪🇸', 'de' => '🇩🇪', 'ru' => '🇷🇺', 'it' => '🇮🇹', 'zh' => '🇨🇳', 'ja' => '🇯🇵', 'lt' => '🇱🇹'];
                                    $flag = $flagMap[$langCode] ?? '🌐';
                                @endphp
                                <span class="mr-2">{{ $flag }}</span>
                                <span>{{ $languages[$langCode]['name'] ?? $langCode }}</span>
                                @if($langCode === config('app.fallback_locale'))
                                    <span class="ml-2 inline-flex items-center rounded-md bg-blue-50 dark:bg-blue-900/20 px-2 py-1 text-xs font-medium text-blue-700 dark:text-blue-300 ring-1 ring-inset ring-blue-600/20 dark:ring-blue-500/30">
                                        {{ __('admin.translations.fallback') }}
                                    </span>
                                @endif
                            </h3>
                            
                            @if(is_string($value))
                                <x-input.form.group :label="__('admin.translations.translation_value')" for="translations_{{ $langCode }}">
                                    <x-input.textarea
                                        id="translations_{{ $langCode }}"
                                        name="translations[{{ $langCode }}]"
                                        rows="3"
                                        class="font-mono text-sm"
                                    >{{ $value }}</x-input.textarea>
                                </x-input.form.group>
                            @elseif(is_array($value))
                                <div class="bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-md">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <x-ui.icon icon="heroicon-s-exclamation-triangle" class="h-5 w-5 text-yellow-400" />
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-300">{{ __('admin.translations.nested_value_warning') }}</h3>
                                            <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-200">
                                                <p>{{ __('admin.translations.nested_value_explanation') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="translations[{{ $langCode }}]" value="[NESTED ARRAY]">
                            @else
                                <div class="bg-red-50 dark:bg-red-900/20 p-4 rounded-md">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <x-ui.icon icon="heroicon-s-x-circle" class="h-5 w-5 text-red-400" />
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-sm font-medium text-red-800 dark:text-red-300">{{ __('admin.translations.invalid_value_type') }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="translations[{{ $langCode }}]" value="">
                            @endif
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-6 flex justify-end">
                    <x-ui.button type="submit" variant="primary">{{ __('admin.translations.save_translations') }}</x-ui.button>
                </div>
            </form>
        </x-ui.card>
    </div>
</x-layout.app> 