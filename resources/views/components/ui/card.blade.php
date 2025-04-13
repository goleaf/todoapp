@props([
    'withBorder' => false,
])

<x-ui.card.index :withBorder="$withBorder" {{ $attributes }}>
    @isset($header)
        <x-slot name="header">{{ $header }}</x-slot>
    @endisset
    
    {{ $slot }}
    
    @isset($footer)
        <x-slot name="footer">{{ $footer }}</x-slot>
    @endisset
</x-ui.card.index> 