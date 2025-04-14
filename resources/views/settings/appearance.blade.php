<x-layout.app :title="__('appearance.title_page')">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('appearance.heading')" :subheading="__('appearance.subheading')">
        <!-- Theme Settings -->
        <div class="mb-8">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ __('appearance.theme_heading') }}</h3>
            <fieldset>
                <legend class="sr-only">{{ __('appearance.theme_heading') }}</legend>
                <x-ui.button.group>
                    <x-ui.button type="button" variant="secondary" before="heroicon-o-sun" value="light" onclick="setAppearance(this.value)">{{ __('appearance.light') }}</x-ui.button>
                    <x-ui.button type="button" variant="secondary" before="heroicon-o-moon" value="dark" onclick="setAppearance(this.value)">{{ __('appearance.dark') }}</x-ui.button>
                    <x-ui.button type="button" variant="secondary" before="heroicon-o-computer-desktop" value="system" onclick="setAppearance(this.value)">{{ __('appearance.system') }}</x-ui.button>
                </x-ui.button.group>
            </fieldset>
        </div>

        <!-- Text Size Settings -->
        <div x-data="textSize()">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ __('appearance.text_size') }}</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">{{ __('appearance.text_size_comfort') }}</p>
            
            <fieldset>
                <legend class="sr-only">{{ __('appearance.text_size') }}</legend>
                <x-ui.button.group>
                    <x-ui.button 
                        type="button" 
                        variant="secondary" 
                        value="small" 
                        x-on:click="setTextSize('small')"
                        class="text-sm"
                        x-bind:class="{ 'bg-gray-200 dark:bg-gray-600': localStorage.getItem('textSize') === 'small' }"
                    >
                        {{ __('appearance.small') }}
                    </x-ui.button>
                    
                    <x-ui.button 
                        type="button" 
                        variant="secondary" 
                        value="medium" 
                        x-on:click="setTextSize('medium')"
                        class="text-base"
                        x-bind:class="{ 'bg-gray-200 dark:bg-gray-600': localStorage.getItem('textSize') === 'medium' || !localStorage.getItem('textSize') }"
                    >
                        {{ __('appearance.medium') }}
                    </x-ui.button>
                    
                    <x-ui.button 
                        type="button" 
                        variant="secondary" 
                        value="large" 
                        x-on:click="setTextSize('large')"
                        class="text-lg"
                        x-bind:class="{ 'bg-gray-200 dark:bg-gray-600': localStorage.getItem('textSize') === 'large' }"
                    >
                        {{ __('appearance.large') }}
                    </x-ui.button>
                </x-ui.button.group>
            </fieldset>
            
            <div class="mt-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <h4 class="font-medium text-gray-900 dark:text-gray-100 mb-2">{{ __('appearance.preview_heading') }}</h4>
                <p class="mb-2" x-bind:class="{
                    'text-sm': localStorage.getItem('textSize') === 'small',
                    'text-base': !localStorage.getItem('textSize') || localStorage.getItem('textSize') === 'medium',
                    'text-lg': localStorage.getItem('textSize') === 'large'
                }">{{ __('appearance.preview_text') }}</p>
                
                <div class="mt-2 grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <x-ui.badge color="green">{{ __('appearance.preview_badge_completed') }}</x-ui.badge>
                    </div>
                    <div>
                        <x-ui.badge color="blue">{{ __('appearance.preview_badge_in_progress') }}</x-ui.badge>
                    </div>
                </div>
            </div>
        </div>
    </x-settings.layout>
</div>

@push('scripts')
<script>
    // Set theme function (already exists)
    function setAppearance(value) {
        const appearance = localStorage.appearance = value;
        
        if (appearance === 'dark' || (appearance === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }
</script>
@endpush

</x-layout.app>
