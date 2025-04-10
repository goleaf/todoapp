<x-layout.auth>
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <a href="/">
            <x-layout.app-logo-icon class="w-8 h-8 mr-2" />
            {{ config('app.name', 'Laravel') }}
        </a>
        <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    {{ __('Confirm Password') }}
                </h1>
                <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                    {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
                </p>

                <form class="space-y-4 md:space-y-6" method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <!-- Password -->
                    <div>
                        <x-form.index.input.label for="password">{{ __('Password') }}</x-input.label>
                        <x-form.index.input.input type="password" name="password" id="password" placeholder="••••••••" class="mt-1" required="" autocomplete="current-password" />
                        <x-form.index.input.input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end">
                         <x-ui.button type="submit" variant="primary" class="w-full">{{ __('Confirm') }}</x-ui.button>
                    </div>
                    
                    {{-- Optional: Add forgot password link if relevant context --}}
                    {{-- @if (Route::has('password.request'))
                        <div class="text-right mt-4">
                            <a class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        </div>
                    @endif --}}
                </form>
            </div>
        </div>
    </div>
</x-layout.auth>
