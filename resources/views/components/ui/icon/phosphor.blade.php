@props(['icon', 'width' => 24, 'height' => 24, 'class' => ''])

















@php
use Illuminate\Support\Str;

$name = Str::afterLast($icon, '.');

if (View::exists("components.ui.icon.phosphor.{$name}")) {
    $component = "ui.icon.phosphor.{$name}";
} else {
    $component = null;
}
@endphp

@if ($component)
    <x-dynamic-component :component="$component" :width="$width" :height="$height" :class="$class" {{ $attributes->except(['icon', 'width', 'height', 'class']) }} />
@else
    <svg {{ $attributes->merge(['class' => $class]) }}>
        <use href="#phosphor-{{ $name }}"></use>
    </svg>
@endif 