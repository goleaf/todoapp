@props([
    'size' => 'base',
    'level' => null,
])





{{-- The logic for determining the tag and classes is now in the PHP class --}}
<{{ $tag }} {{ $attributes->class($computedClasses) }} data-heading>{{ $slot }}</{{ $tag }}>
