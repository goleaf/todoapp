@props(['title' => config('app.name')])

<x-layout.app.index :title="$title" {{ $attributes }}>
    {{ $slot }}
</x-layout.app.index> 