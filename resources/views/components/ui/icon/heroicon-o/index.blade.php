@props(['name' => null])

@php
    $name = $name ?? $slot->isEmpty() ? null : $slot->trim();
    $attrs = $attributes->merge(['class' => 'h-5 w-5']);
@endphp

@if($name)
    <x-heroicon-o-{{ $name }} {{ $attrs }} />
@else
    <span {{ $attrs }}></span>
@endif 