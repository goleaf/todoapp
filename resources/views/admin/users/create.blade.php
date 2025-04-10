<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin - Create New User') }}
        </h2>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                <div class="space-y-12">
                    <div class="border-b border-gray-900/10 dark:border-gray-700 pb-12">
                        <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-gray-100">{{ __('User Information') }}</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-400">{{ __('Enter the details for the new user account.') }}</p>

                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            {{-- Name --}}
                            <div class="sm:col-span-3">
                                <label for="name" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300">{{ __('Name') }}</label>
                                <div class="mt-2">
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" autocomplete="name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-300 dark:bg-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 @error('name') ring-red-500 dark:ring-red-500 @enderror" required>
                                </div>
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="sm:col-span-3">
                                <label for="email" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300">{{ __('Email address') }}</label>
                                <div class="mt-2">
                                    <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" class="block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-300 dark:bg-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 @error('email') ring-red-500 dark:ring-red-500 @enderror" required>
                                </div>
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="sm:col-span-3">
                                <label for="password" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300">{{ __('Password') }}</label>
                                <div class="mt-2">
                                    <input type="password" name="password" id="password" autocomplete="new-password" class="block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-300 dark:bg-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 @error('password') ring-red-500 dark:ring-red-500 @enderror" required>
                                </div>
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                             {{-- Confirm Password --}}
                            <div class="sm:col-span-3">
                                <label for="password_confirmation" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300">{{ __('Confirm Password') }}</label>
                                <div class="mt-2">
                                    <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password" class="block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-300 dark:bg-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6" required>
                                </div>
                                 {{-- Note: No @error for confirmation, handled by 'password' rule often --}}
                            </div>
                            
                            {{-- Optional: Add Role selection if using roles/permissions --}}

                        </div>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <a href="{{ route('admin.users.index') }}" class="text-sm font-semibold leading-6 text-gray-900 dark:text-gray-300">{{ __('Cancel') }}</a>
                    <button type="submit" class="rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">
                         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-1.5 -ml-0.5 inline-block">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                        </svg>
                        {{ __('Create User') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
