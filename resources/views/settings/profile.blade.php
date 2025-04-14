<x-layout.app :title="__('profile.title')">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('profile.header')" :subheading="__('profile.subheading')">
        <x-input.form method="put" action="{{ route('settings.profile.update') }}" class="my-6 w-full space-y-6">
            <x-input.input type="text" :label="__('profile.name')" :value="$user->name" name="name" required autofocus autocomplete="name" />

            <div>
                <x-input.input type="email" :label="__('profile.email')" :value="$user->email" name="email" required autocomplete="email" />

                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail &&! auth()->user()->hasVerifiedEmail())
                    <div>
                        <x-layout.text class="mt-4">
                            {{ __('profile.email_unverified') }}

                            <x-ui.button variant="link" :formaction="route('verification.store')" name="_method" value="post">
                                {{ __('profile.resend_verification') }}
                            </x-ui.button>
                        </x-layout.text>

                        @if (session('status') === 'verification-link-sent')
                            <x-layout.text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                                {{ __('profile.verification_sent') }}
                            </x-layout.text>
                        @endif
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <x-ui.button class="w-full">{{ __('profile.save') }}</x-ui.button>
                </div>

                <x-feedback.action-message class="me-3" on="profile-updated">
                    {{ __('profile.saved') }}
                </x-feedback.action-message>
            </div>
        </x-input.form>

        <section class="mt-10 space-y-6">
            <div class="relative mb-5">
                <x-layout.heading>{{ __('profile.delete_account') }}</x-layout.heading>
                <x-layout.subheading>{{ __('profile.delete_account_desc') }}</x-layout.subheading>
            </div>

            <x-ui.button type="button" variant="danger" x-init="" x-on:click="$dispatch('modal:open', 'confirm_user_deletion')">
                {{ __('profile.delete_account') }}
            </x-ui.button>

            <x-ui.modal id="confirm_user_deletion" :open="$errors->has('password')">
                <x-input.form method="delete" action="{{ route('settings.profile.destroy') }}" class="space-y-6">
                    <div>
                        <x-layout.heading size="lg">{{ __('profile.confirm_delete') }}</x-layout.heading>
                        <x-layout.subheading>
                            {{ __('profile.confirm_delete_desc') }}
                        </x-layout.subheading>
                    </div>

                    <x-input.input type="password" :label="__('profile.password')" name="password" />

                    <div class="flex justify-end space-x-2">
                        <x-ui.button variant="secondary" form="confirm_user_deletion_close">{{ __('profile.cancel') }}</x-ui.button>
                        <x-ui.button variant="danger">{{ __('profile.delete_account') }}</x-ui.button>
                    </div>
                </x-input.form>
            </x-ui.modal>
        </section>
    </x-settings.layout>
</div>
</x-layout.app>
