<x-layout.app :title="__('settings.password_page_title')">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('settings.password_heading')" :subheading="__('settings.password_subheading')">
        <x-input.form method="put" action="{{ route('settings.password.update') }}" class="mt-6 space-y-6">
            <x-input.input
                type="password"
                name="current_password"
                :label="__('settings.current_password')"
                required
                autocomplete="current-password"
            />
            <x-input.input
                type="password"
                name="password"
                :label="__('settings.new_password')"
                required
                autocomplete="new-password"
            />
            <x-input.input
                type="password"
                name="password_confirmation"
                :label="__('settings.confirm_password')"
                required
                autocomplete="new-password"
            />

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <x-ui.button class="w-full">{{ __('settings.save_button') }}</x-ui.button>
                </div>

                <x-feedback.action-message class="me-3" on="password-updated">
                    {{ __('settings.saved_message') }}
                </x-feedback.action-message>
            </div>
        </x-input.form>
    </x-settings.layout>
</div>
</x-layout.app>
