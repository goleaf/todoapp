@props([
    'header' => null,
    'footer' => null,
    'padding' => 'normal',
    'withShadow' => true,
    'withBorder' => false,
    'withHover' => false
])

<x-ui.card.index
    :header="$header"
    :footer="$footer"
    :padding="$padding"
    :withShadow="$withShadow"
    :withBorder="$withBorder"
    :withHover="$withHover"
    {{ $attributes }}
>
    {{ $slot }}
</x-ui.card.index> 