@props([
    'href' => '#',
    'color' => 'primary',
])

<x-ui.link.index :href="$href" :color="$color" {{ $attributes }}>
    {{ $slot }}
</x-ui.link.index> 