<x-layout.app :title="__('settings.language.page_title')">
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <x-layout.section-header>
                <x-slot name="title">{{ __('settings.language.heading') }}</x-slot>
                <x-slot name="description">{{ __('settings.language.description') }}</x-slot>
            </x-layout.section-header>

            <div class="mt-5 md:mt-0 md:col-span-2">
                <x-ui.card withBorder>
                    <x-feedback.alert-messages />
                    
                    <form method="POST" action="{{ route('settings.language.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="px-4 py-5 bg-white dark:bg-gray-800 sm:p-6">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6">
                                    <x-input.label for="locale" value="{{ __('settings.language.locale_label') }}" />
                                    
                                    <div class="mt-4 space-y-4">
                                        @php
                                            $languages = App\Models\Language::getAvailableLanguages();
                                            $flagMap = [
                                                'en' => '🇬🇧', 
                                                'ru' => '🇷🇺', 
                                                'es' => '🇪🇸', 
                                                'fr' => '🇫🇷', 
                                                'de' => '🇩🇪',
                                                'it' => '🇮🇹',
                                                'ja' => '🇯🇵',
                                                'zh' => '🇨🇳',
                                                'lt' => '🇱🇹'
                                            ];
                                        @endphp
                                        
                                        @foreach($languages as $code => $lang)
                                            <div class="relative flex items-start py-2 px-3 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                                <div class="min-w-0 flex-1 text-sm">
                                                    <label for="language-{{ $code }}" class="font-medium text-gray-700 dark:text-gray-300 select-none flex items-center">
                                                        <span class="text-xl mr-2">{{ $flagMap[$code] ?? '🌐' }}</span>
                                                        <span>{{ $lang['name'] }}</span>
                                                        <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">({{ $code }})</span>
                                                    </label>
                                                </div>
                                                <div class="ml-3 flex items-center h-5">
                                                    <x-input.radio 
                                                        id="language-{{ $code }}" 
                                                        name="locale" 
                                                        value="{{ $code }}" 
                                                        :checked="$currentLocale === $code"
                                                    />
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    <x-input.input-error for="locale" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end px-4 py-3 bg-gray-50 dark:bg-gray-700 text-right sm:px-6">
                            <x-ui.button type="submit">
                                {{ __('settings.language.save') }}
                            </x-ui.button>
                        </div>
                    </form>
                </x-ui.card>
            </div>
        </div>
    </div>
</x-layout.app> 