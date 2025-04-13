@props(['striped' => false])

<x-data.table.index :striped="$striped" {{ $attributes }}>
    {{ $slot }}
</x-data.table.index> 