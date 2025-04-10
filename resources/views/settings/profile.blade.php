<x-layout.app :title="__('Profile | Settings')">
<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your name and email address')">
        <x-input.form method="put" action="{{ route('settings.profile.update') }}" class="my-6 w-full space-y-6">
            <x-input.input type="text" :label="__('Name')" :value="$user->name" name="name" required autofocus autocomplete="name" />

            <div>
                <x-input.input type="email" :label="__('Email')" :value="$user->email" name="email" required autocomplete="email" />

                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail &&! auth()->user()->hasVerifiedEmail())
                    <div>
                        <x-layout.text class="mt-4">
                            {{ __('Your email address is unverified.') }}

                            <x-ui.button variant="link" :formaction="route('verification.store')" name="_method" value="post">
                                {{ __('Click here to re-send the verification email.') }}
                            </x-ui.button>
                        </x-layout.text>

                        @if (session('status') === 'verification-link-sent')
                            <x-layout.text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </x-layout.text>
                        @endif
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <x-ui.button class="w-full">{{ __('Save') }}</x-ui.button>
                </div>

                <x-feedback.action-message class="me-3" on="profile-updated">
                    {{ __('Saved.') }}
                </x-feedback.action-message>
            </div>
        </x-input.form>

        <section class="mt-10 space-y-6">
            <div class="relative mb-5">
                <x-layout.heading>{{ __('Delete account') }}</x-layout.heading>
                <x-layout.subheading>{{ __('Delete your account and all of its resources') }}</x-layout.subheading>
            </div>

            <x-ui.button type="button" variant="danger" x-init="" x-on:click="$dispatch('modal:open', 'confirm_user_deletion')">
                {{ __('Delete account') }}
            </x-ui.button>

            <x-ui.modal id="confirm_user_deletion" :open="$errors->has('password')">
                <x-input.form method="delete" action="{{ route('settings.profile.destroy') }}" class="space-y-6">
                    <div>
                        <x-layout.heading size="lg">{{ __('Are you sure you want to delete your account?') }}</x-layout.heading>
                        <x-layout.subheading>
                            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                        </x-layout.subheading>
                    </div>

                    <x-input.input type="password" :label="__('Password')" name="password" />

                    <div class="flex justify-end space-x-2">
                        <x-ui.button variant="secondary" form="confirm_user_deletion_close">{{ __('Cancel') }}</x-ui.button>
                        <x-ui.button variant="danger">{{ __('Delete account') }}</x-ui.button>
                    </div>
                </x-input.form>
            </x-ui.modal>
        </section>
    </x-settings.layout>
</section>
</x-layout.app>
