@props([])

@if (session('success'))
    <x-feedback.alert type="success" :dismissible="true" class="mb-4">
        {{ session('success') }}
    </x-feedback.alert>
@endif

@if (session('error'))
    <x-feedback.alert type="error" :dismissible="true" class="mb-4">
        {{ session('error') }}
    </x-feedback.alert>
@endif

@if (session('warning'))
    <x-feedback.alert type="warning" :dismissible="true" class="mb-4">
        {{ session('warning') }}
    </x-feedback.alert>
@endif

@if (session('info'))
    <x-feedback.alert type="info" :dismissible="true" class="mb-4">
        {{ session('info') }}
    </x-feedback.alert>
@endif

@if (session('status'))
    <x-feedback.alert type="success" :dismissible="true" class="mb-4">
        {{ session('status') }}
    </x-feedback.alert>
@endif
