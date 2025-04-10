<x-layout.auth>
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <a href="/">
            <x-layout.app-logo-icon class="w-8 h-8 mr-2" />
            {{ config('app.name', 'Laravel') }}
        </a>
        <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    {{ __('Forgot your password?') }}
                </h1>
                <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                    {{ __('No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                </p>

                <!-- Session Status -->
                <x-auth.auth-session-status class="mb-4" :status="session('status')" />

                <form class="space-y-4 md:space-y-6" method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input.input.label for="email">{{ __('Your email') }}</x-input.label>
                        <x-input.input type="email" name="email" id="email" class="mt-1" placeholder="name@company.com" required="" :value="old('email')" autofocus autocomplete="username" />
                        <x-input.input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end">
                         <x-ui.button type="submit" variant="primary" class="w-full">{{ __('Email Password Reset Link') }}</x-ui.button>
                    </div>

                     <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                        <x-ui.link :href="route('login')">{{ __('Back to login') }}</x-ui.link>
                    </p>
                </form>
            </div>
        </div>
    </div>
</x-layout.auth>
