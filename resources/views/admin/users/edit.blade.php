<x-layout.app>
    <x-slot name="header">
         <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Admin - Edit User') }}: {{ $user->name }}
            </h2>
            <x-ui.button 
                href="{{ route('admin.users.index') }}" 
                variant="secondary" 
                :icon="app('heroicon')->solid('arrow-left')"
            >
                {{ __('Back to Users') }}
            </x-ui.button>
        </div>
    </x-slot>

    <x-ui.card withBorder>
        <x-slot name="header">
            <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-gray-100">{{ __('User Information') }}</h2>
            <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-400">{{ __('Update the user's account details.') }}</p>
        </x-slot>
        
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')
            <div class="space-y-12">
                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    {{-- Name --}}
                    <div class="sm:col-span-3">
                        <x-form.index.input.form.group :label="__('Name')" for="name" :error="$errors->first('name')">
                            <x-form.index.input.input 
                                type="text" 
                                name="name" 
                                id="name" 
                                :value="old('name', $user->name)" 
                                required 
                                autofocus 
                                :invalid="$errors->has('name')" 
                            />
                        </x-input.form.group>
                    </div>

                    {{-- Email --}}
                    <div class="sm:col-span-3">
                        <x-form.index.input.form.group :label="__('Email address')" for="email" :error="$errors->first('email')">
                            <x-form.index.input.input 
                                type="email" 
                                name="email" 
                                id="email" 
                                :value="old('email', $user->email)" 
                                required 
                                :invalid="$errors->has('email')" 
                            />
                        </x-input.form.group>
                    </div>

                    {{-- Password --}}
                    <div class="sm:col-span-3">
                        <x-form.index.input.form.group 
                            :label="__('New Password')" 
                            for="password" 
                            :error="$errors->first('password')"
                            :helpText="__('Leave blank to keep the current password.')"
                        >
                            <x-form.index.input.input 
                                type="password" 
                                name="password" 
                                id="password" 
                                :invalid="$errors->has('password')" 
                            />
                        </x-input.form.group>
                    </div>

                    {{-- Confirm Password --}}
                    <div class="sm:col-span-3">
                        <x-form.index.input.form.group :label="__('Confirm New Password')" for="password_confirmation">
                            <x-form.index.input.input 
                                type="password" 
                                name="password_confirmation" 
                                id="password_confirmation" 
                            />
                        </x-input.form.group>
                    </div>
                    
                    {{-- Optional: Add Role selection/display if using roles/permissions --}}
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <x-ui.button 
                    href="{{ route('admin.users.index') }}" 
                    variant="secondary"
                >
                    {{ __('Cancel') }}
                </x-ui.button>
                <x-ui.button 
                    type="submit" 
                    variant="primary" 
                    :icon="app('heroicon')->outline('arrow-path')"
                >
                    {{ __('Update User') }}
                </x-ui.button>
            </div>
        </form>
    </x-ui.card>
</x-layout.app>
