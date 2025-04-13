@props(['href' => '#', 'external' => false])

<x-ui.link.index :href="$href" :external="$external" {{ $attributes }}>
    {{ $slot }}
</x-ui.link.index> 