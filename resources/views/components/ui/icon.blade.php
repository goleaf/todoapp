@props(['icon', 'class' => '', 'width' => 24, 'height' => 24])

















@if (is_string($icon) && (str_starts_with($icon, 'heroicon-') || str_starts_with($icon, 'phosphor-')))
    @icon($icon, $class)
@elseif (is_string($icon) && View::exists("components.ui.icon.heroicon-o.{$icon}"))
    <x-dynamic-component component="ui.icon.heroicon-o.{{ $icon }}" :class="$class" {{ $attributes->except(['class', 'icon']) }} />
@elseif (is_string($icon))
    {{-- Fallback SVG for icon not found --}}
    <svg xmlns="http://www.w3.org/2000/svg" {{ $attributes->merge(['class' => $class]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
@else
    {{ $icon }}
@endif 