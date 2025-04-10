@props(['title' => config('app.name')])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" x-bind:class="{'dark': darkMode }">
<head>
    <x-layout.app.head :title="$title" />
</head>
<body class="font-sans antialiased h-full">
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <div class="flex justify-center">
                <x-layout.app.logo-icon class="h-12 w-auto text-primary-600" />
            </div>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <div class="bg-white dark:bg-gray-800 px-6 py-8 shadow-sm sm:rounded-lg sm:px-8">
                {{ $slot }}
            </div>
            
            @if(isset($footer))
                <div class="mt-6 text-center text-sm text-gray-500 dark:text-gray-400">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</body>
</html> 