@props(['icon', 'classes'])

@if ($icon)
    <x-ui.icon :icon="$icon" :class="$classes" />
@endif 