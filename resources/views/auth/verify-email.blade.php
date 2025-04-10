<x-layout.auth :title="__('Verification required')">
<div class="mt-4 space-y-6">
    <x-layout.text class="text-center">
        {{ __('Please verify your email address by clicking on the link we just emailed to you.') }}
    </x-layout.text>

    @if (session('status') == 'verification-link-sent')
        <x-layout.text class="text-center font-medium !dark:text-green-400 !text-green-600">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </x-layout.text>
    @endif

    <div class="flex flex-col items-center justify-between space-y-3">
        <x-input.form method="post" action="{{ route('verification.store') }}">
            <x-ui.button class="w-full">
                {{ __('Resend verification email') }}
            </x-ui.button>
        </x-input.form>
        <x-input.form method="post" action="{{ route('logout') }}">
            <x-ui.button variant="link">{{ __('Log out') }}</x-ui.button>
        </x-input.form>
    </div>
</div>
</x-layout.auth>
