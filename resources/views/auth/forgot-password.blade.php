<x-layout.auth :title="__('Forgot password')">
 <div class="space-y-6">
    <x-auth.auth-header :title="__('Forgot password')" :description="__('Enter your email to receive a password reset link')" />

    <!-- Session Status -->
    <x-auth.auth-session-status class="text-center" :status="session('status')" />

    <x-input.form method="post" action="{{ route('password.email') }}" class="space-y-6">
        <!-- Email Address -->
        <x-input.input
            type="email"
            :label="__('auth.email')"
            name="email"
            required
            autofocus
        />

        <x-ui.button class="w-full">{{ __('Email password reset link') }}</x-ui.button>
    </x-input.form>

    <div class="text-center text-sm text-gray-600 dark:text-gray-400">
        {{ __('auth.or_return_to') }}
        <x-ui.link :href="route('login')">{{ __('auth.log_in') }}</x-ui.link>
    </div>
</div>
</x-layout.auth>
