@props([
    'type' => 'link',
    'href' => null,
    'before' => null,
    'after' => null,
    'destructive' => false,
])

<x-ui.popover.item.index
    :type="$type"
    :href="$href"
    :before="$before"
    :after="$after"
    :destructive="$destructive"
    {{ $attributes }}
>
    {{ $slot }}
</x-ui.popover.item.index> 