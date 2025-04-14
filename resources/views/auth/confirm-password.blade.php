<x-layout.auth :title="__('Confirm password')">
<div class="space-y-6">
    <x-auth.auth-header
        :title="__('Confirm password')"
        :description="__('This is a secure area of the application. Please confirm your password before continuing.')"
    />

    <!-- Session Status -->
    <x-auth.auth-session-status class="text-center" :status="session('status')" />

    <x-input.form method="post" action="{{ route('confirmation.store') }}" class="space-y-6">
        <!-- Password -->
        <x-input.input
            type="password"
            :label="__('Password')"
            name="password"
            required
            autocomplete="new-password"
        />

        <x-ui.button class="w-full">{{ __('Confirm') }}</x-ui.button>
    </x-input.form>
</div>
</x-layout.auth>
