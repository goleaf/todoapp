@props(['icon', 'classes'])

@php
    use Illuminate\Support\Str;
@endphp

@if (is_string($icon) && Str::startsWith($icon, 'heroicon-o-'))
    @php $iconName = Str::after($icon, 'heroicon-o-'); @endphp
    <x-ui.dynamic-component :component="'ui.icon.heroicon-o-'.$iconName" class="{{ $classes }}" />
@elseif (is_string($icon) && Str::startsWith($icon, 'heroicon-s-'))
    @php $iconName = Str::after($icon, 'heroicon-s-'); @endphp
    <x-ui.dynamic-component :component="'ui.icon.heroicon-s-'.$iconName" class="{{ $classes }}" />
@elseif (is_string($icon) && Str::startsWith($icon, 'phosphor-'))
    @php $iconName = Str::after($icon, 'phosphor-'); @endphp
    <x-ui.dynamic-component :component="'ui.icon.phosphor-'.$iconName" class="{{ $classes }}" />
@else
    {{ $icon }}
@endif 