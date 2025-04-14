<x-layout.auth :title="__('Sign up')">
<div class="space-y-6">
    <x-auth.auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

    <!-- Session Status -->
    <x-auth.auth-session-status class="text-center" :status="session('status')" />

    <x-input.form method="post" :action="route('register')" class="space-y-6">
        <!-- Name -->
        <div>
            <x-input.label for="name">{{ __('Your Name') }}</x-input.label>
            <x-input.input type="text" name="name" id="name" class="mt-1" :placeholder="__('auth.name_placeholder')" required="" :value="old('name')" autofocus autocomplete="name" />
            <x-input.input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input.label for="email">{{ __('Your email') }}</x-input.label>
            <x-input.input type="email" name="email" id="email" class="mt-1" :placeholder="__('auth.email_placeholder')" required="" :value="old('email')" autocomplete="username" />
            <x-input.input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input.label for="password">{{ __('Password') }}</x-input.label>
            <x-input.input type="password" name="password" id="password" :placeholder="__('auth.password_placeholder')" class="mt-1" required="" autocomplete="new-password" />
            <x-input.input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input.label for="password_confirmation">{{ __('Confirm Password') }}</x-input.label>
            <x-input.input type="password" name="password_confirmation" id="password_confirmation" :placeholder="__('auth.password_placeholder')" class="mt-1" required="" autocomplete="new-password" />
            <x-input.input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <x-ui.button type="submit" variant="primary" class="w-full mt-4">{{ __('Create an account') }}</x-ui.button>
    </x-input.form>

    <div class="space-x-1 text-center text-sm text-gray-600 dark:text-gray-400">
        {{ __('Already have an account?') }}
        <x-ui.link :href="route('login')">{{ __('Login here') }}</x-ui.link>
    </div>
</div>
</x-layout.auth>
