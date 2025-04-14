<x-layout.app :title="__('Password | Settings')">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Update password')" :subheading="__('Ensure your account is using a long, random password to stay secure')">
        <x-input.form method="put" action="{{ route('settings.password.update') }}" class="mt-6 space-y-6">
            <x-input.input
                type="password"
                name="current_password"
                :label="__('Current password')"
                required
                autocomplete="current-password"
            />
            <x-input.input
                type="password"
                name="password"
                :label="__('New password')"
                required
                autocomplete="new-password"
            />
            <x-input.input
                type="password"
                name="password_confirmation"
                :label="__('Confirm Password')"
                required
                autocomplete="new-password"
            />

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <x-ui.button class="w-full">{{ __('Save') }}</x-ui.button>
                </div>

                <x-feedback.action-message class="me-3" on="password-updated">
                    {{ __('Saved.') }}
                </x-feedback.action-message>
            </div>
        </x-input.form>
    </x-settings.layout>
</div>
</x-layout.app>
