@props(['containerClass' => ''])

<nav {{ $attributes->class(['flex items-center space-x-4', $containerClass]) }}>
    {{ $slot }}
</nav>
