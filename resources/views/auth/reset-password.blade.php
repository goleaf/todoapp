<x-layout.auth :title="__('Reset password')">
<div class="space-y-6">
    <x-auth.auth-header :title="__('Reset password')" :description="__('Please enter your new password below')" />

    <!-- Session Status -->
    <x-auth.auth-session-status class="text-center" :status="session('status')" />

    <x-input.form method="post" action="{{ route('password.store', $request->token) }}" class="space-y-6">
        <!-- Email Address -->
        <x-input.input
            type="email"
            :label="__('Email')"
            name="email"
            :value="$request->email"
            required
            autocomplete="email"
        />

        <!-- Password -->
        <x-input.input
            type="password"
            :label="__('Password')"
            name="password"
            required
            autocomplete="new-password"
        />

        <!-- Confirm Password -->
        <x-input.input
            type="password"
            :label="__('Confirm password')"
            name="password_confirmation"
            required
            autocomplete="new-password"
        />

        <x-ui.button class="w-full">{{ __('Reset password') }}</x-ui.button>
    </x-input.form>
</div>
</x-layouts.auth>
