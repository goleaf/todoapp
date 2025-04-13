@props(['component'])

@php
    $data = $attributes->except(['component'])->getAttributes();
@endphp

<x-dynamic-component :component="$component" {{ $attributes }}>
    {{ $slot }}
</x-dynamic-component> 