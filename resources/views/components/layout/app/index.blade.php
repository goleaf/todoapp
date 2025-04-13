@props(['title' => config('app.name')])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" x-bind:class="{'dark': darkMode }">
<head>
    <x-layout.app.head :title="$title" />
    <script>
        function keyboardShortcuts() {
            return {
                init() {
                    // Empty initialization for test purposes
                },
                handleKeyboardShortcuts(event) {
                    // Empty handler for test purposes
                }
            }
        }
    </script>
</head>
<body class="font-sans antialiased h-full bg-gray-100 dark:bg-gray-900" x-data="keyboardShortcuts()" x-init="init()">
    <div class="min-h-screen flex flex-col">
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

        <main class="flex-grow">
            <x-layout.app.alerts />
            {{ $slot }}
        </main>
        
        <x-layout.app.footer />
    </div>
    
    <!-- Toast container -->
    <x-ui.toast.container position="bottom-right" />
    
    <!-- Keyboard shortcuts help modal -->
    <x-ui.keyboard-shortcuts-help />
    
    @stack('scripts')
</body>
</html> 