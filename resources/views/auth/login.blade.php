<x-layout.auth :title="__('auth.log_in')">
    <x-auth.auth-header :title="__('auth.log_in_to_account')" :description="__('auth.enter_credentials')" />

    <div class="mt-6">
        <x-auth.auth-session-status class="text-center" :status="session('status')" />

        <x-input.form method="post" :action="route('login')" class="space-y-6">
            <div>
                <x-input.label for="email">{{ __('auth.your_email') }}</x-input.label>
                <x-input.input type="email" name="email" id="email" class="mt-1" :placeholder="__('auth.email_placeholder')" required="" :value="old('email')" autofocus autocomplete="username" />
                <x-input.input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <x-input.label for="password">{{ __('auth.password') }}</x-input.label>
                <x-input.input type="password" name="password" id="password" :placeholder="__('auth.password_placeholder')" class="mt-1" required="" autocomplete="current-password" />
                <x-input.input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <x-input.checkbox id="remember" name="remember" />
                    <div class="ml-2">
                        <x-input.label for="remember">{{ __('auth.remember_me') }}</x-input.label>
                    </div>
                </div>
                <x-ui.link :href="route('password.request')">{{ __('auth.forgot_password') }}</x-ui.link>
            </div>

            <x-ui.button type="submit" variant="primary" class="w-full mt-4">{{ __('auth.log_in') }}</x-ui.button>
        </x-input.form>
    </div>

    <x-slot name="footer">
        {{ __("auth.no_account") }} <x-ui.link :href="route('register')">{{ __('auth.sign_up') }}</x-ui.link>
    </x-slot>
</x-layout.auth>
