@props([
    'title',
    'description',
])

<div class="text-center">
    <x-layout.heading size="xl">{{ $title }}</x-layout.heading>
    <x-layout.subheading>{{ $description }}</x-layout.subheading>
</div>
