@props([
    'variant' => 'primary', 
    'size' => 'md', 
    'icon' => null, 
    'iconPosition' => 'left',
    'href' => null,
    'type' => 'button'
])

<x-ui.button.index
    :variant="$variant"
    :size="$size"
    :icon="$icon"
    :iconPosition="$iconPosition"
    :href="$href"
    :type="$type"
    {{ $attributes }}
>
    {{ $slot }}
</x-ui.button.index> 