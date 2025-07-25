@props([])

















<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white antialiased dark:bg-linear-to-b dark:from-gray-950 dark:to-gray-900">
        <div class="relative grid h-dvh flex-col items-center justify-center px-8 sm:px-0 lg:max-w-none lg:grid-cols-2 lg:px-0">
            <div class="relative hidden h-full flex-col p-10 text-white lg:flex dark:border-r dark:border-gray-800">
                <div class="absolute inset-0 bg-gray-900"></div>
                <a href="{{ route('home') }}" class="relative z-20 flex items-center text-lg font-medium">
                    <span class="flex h-10 w-10 items-center justify-center rounded-md">
                        <x-layout.app.logo-icon class="mr-2 h-7 fill-current text-white" />
                    </span>
                    {{ config('app.name', 'Laravel') }}
                </a>

                @php
                    [$message, $author] = str(Illuminate\Foundation\Inspiring::quotes()->random())->explode('-');
                @endphp

                <div class="relative z-20 mt-auto">
                    <blockquote class="space-y-2">
                        <x-layout.heading size="xl">&ldquo;{{ trim($message) }}&rdquo;</x-layout.heading>
                        <footer><x-layout.heading>{{ trim($author) }}</x-layout.heading></footer>
                    </blockquote>
                </div>
            </div>
            <div class="w-full lg:p-8">
                <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[350px]">
                    <a href="{{ route('home') }}" class="z-20 flex flex-col items-center gap-2 font-medium lg:hidden">
                        <span class="flex h-9 w-9 items-center justify-center rounded-md">
                            <x-layout.app.logo-icon class="size-9 fill-current text-black dark:text-white" />
                        </span>

                        <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                    </a>
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
