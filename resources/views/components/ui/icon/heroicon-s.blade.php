@props(['icon', 'width' => 24, 'height' => 24, 'class' => ''])

















@php
use Illuminate\Support\Str;

$name = Str::afterLast($icon, '.');

if (View::exists("components.ui.icon.heroicon-s.{$name}")) {
    $component = "ui.icon.heroicon-s.{$name}";
} else {
    $component = null;
}
@endphp

@if ($component)
    <x-dynamic-component :component="$component" :width="$width" :height="$height" :class="$class" {{ $attributes->except(['icon', 'width', 'height', 'class']) }} />
@else
    <svg {{ $attributes->merge(['class' => $class]) }}>
        <use href="#heroicon-s-{{ $name }}"></use>
    </svg>
@endif 