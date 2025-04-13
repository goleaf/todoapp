@props([
    'id' => null,
    'maxWidth' => null,
    'fullscreen' => false,
])

<x-ui.modal.index
    :id="$id"
    :maxWidth="$maxWidth"
    :fullscreen="$fullscreen"
    {{ $attributes }}
>
    @isset($title)
        <x-slot name="title">{{ $title }}</x-slot>
    @endisset
    
    {{ $slot }}
    
    @isset($footer)
        <x-slot name="footer">{{ $footer }}</x-slot>
    @endisset
</x-ui.modal.index> 