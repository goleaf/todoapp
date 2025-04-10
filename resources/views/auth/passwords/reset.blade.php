<x-layout.auth>
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <a href="/">
            <x-layout.app.logo-icon class="w-8 h-8 mr-2" />
            {{ config('app.name', 'Laravel') }}
        </a>
        <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    {{ __('Reset your password') }}
                </h1>

                 <!-- Session Status -->
                 {{-- Although less common here, you might still want session status --}}
                <x-auth.auth-session-status class="mb-4" :status="session('status')" />

                <form class="space-y-4 md:space-y-6" method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $token }}">

                    <!-- Email Address -->
                    <div>
                        <x-input.label for="email">{{ __('Your email') }}</x-input.label>
                        <x-input.input type="email" name="email" id="email" class="mt-1" placeholder="name@company.com" required="" :value="old('email', $request->email)" autofocus autocomplete="username" />
                        <x-input.input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input.label for="password">{{ __('New Password') }}</x-input.label>
                        <x-input.input type="password" name="password" id="password" placeholder="••••••••" class="mt-1" required="" autocomplete="new-password" />
                        <x-input.input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                     <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-input.label for="password_confirmation">{{ __('Confirm New Password') }}</x-input.label>
                        <x-input.input type="password" name="password_confirmation" id="password_confirmation" placeholder="••••••••" class="mt-1" required="" autocomplete="new-password" />
                        <x-input.input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                    
                    <x-ui.button type="submit" variant="primary" class="w-full">{{ __('Reset Password') }}</x-ui.button>
                
                </form>
            </div>
        </div>
    </div>
</x-layout.auth>
