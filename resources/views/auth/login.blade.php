<x-layout.auth :title="__('Log in')">
    <x-auth.auth-header :title="__('Log in to your account')" :description="__('Enter your email and password below to log in')" />

    <div class="mt-6">
        <x-auth.auth-session-status class="text-center" :status="session('status')" />

        <x-input.form method="post" :action="route('login')" class="space-y-6">
            <div>
                <x-input.label for="email">{{ __('Your email') }}</x-input.label>
                <x-input.input type="email" name="email" id="email" class="mt-1" placeholder="name@company.com" required="" :value="old('email')" autofocus autocomplete="username" />
                <x-input.input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <div class="flex items-center justify-between">
                    <x-input.label for="password">{{ __('Password') }}</x-input.label>
                    <x-input.input type="password" name="password" id="password" placeholder="••••••••" class="mt-1" required="" autocomplete="current-password" />
                    <x-input.input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <x-input.checkbox id="remember" name="remember" />
                    <div class="ml-2">
                        <x-input.label for="remember">{{ __('Remember me') }}</x-input.label>
                    </div>
                </div>
                <x-ui.link :href="route('password.request')">{{ __('Forgot your password?') }}</x-ui.link>
            </div>

            <x-ui.button type="submit" variant="primary" class="w-full mt-4">{{ __('Log in') }}</x-ui.button>
        </x-input.form>
    </div>

    <x-slot name="footer">
        {{ __("Don't have an account?") }} <x-ui.link :href="route('register')">{{ __('Sign up') }}</x-ui.link>
    </x-slot>
</x-layout.auth>
