@props(['title' => config('app.name')])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" x-bind:class="{'dark': darkMode }">
<head>
    <x-layout.app.head :title="$title" />
</head>
<body class="font-sans antialiased h-full bg-gray-100 dark:bg-gray-900">
    <div class="min-h-screen">
        <x-layout.app.header />
        <x-layout.app.sidebar />
        <x-layout.app.mobile-menu />

        @if (isset($header))
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="flex justify-between items-center max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <main>
            @include('layouts.partials.alerts')
            {{ $slot }}
        </main>
    </div>
    
    @stack('scripts')
</body>
</html> 