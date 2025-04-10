@props([
    'title',
    'description',
])

<div class="text-center">
    <x-layout.heading size="xl">{{ $title }}</x-heading>
    <x-layout.subheading>{{ $description }}</x-subheading>
</div>
