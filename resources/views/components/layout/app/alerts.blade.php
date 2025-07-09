@props([])

















@if (session('status'))
    <div class="max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8">
        <x-feedback.alert type="success" :dismissible="true" class="mt-2">
            {{ session('status') }}
        </x-feedback.alert>
    </div>
@endif

@if ($errors->any())
    <div class="max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8">
        <x-feedback.alert type="danger" :dismissible="true" class="mt-2">
            <ul class="list-disc list-inside pl-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-feedback.alert>
    </div>
@endif

@if (session('success'))
    <div class="max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8">
        <x-feedback.alert type="success" :dismissible="true" class="mt-2">
            {{ session('success') }}
        </x-feedback.alert>
    </div>
@endif

@if (session('error'))
    <div class="max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8">
        <x-feedback.alert type="danger" :dismissible="true" class="mt-2">
            {{ session('error') }}
        </x-feedback.alert>
    </div>
@endif 