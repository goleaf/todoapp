@props([
    'stashable' => null,
    'sticky' => null,
])

@php
if ($sticky) {
    $attributes = $attributes->class([
        'sticky top-0 max-h-screen overflow-y-auto',
    ]);
}

if ($stashable) {
    $attributes = $attributes->class([
        'hidden lg:block',
    ]);
}
@endphp

<?php if($stashable) : ?>
<div
    class="fixed inset-0 bg-black/10 hidden lg:hidden"
    x-on:click="document.body.removeAttribute('data-show-stashed-sidebar')"
></div>
<?php endif; ?>

<div {{ $attributes->class([
    'flex flex-col gap-4 w-64 p-4 border-r border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-900',
]) }}>
    {{ $slot }}
</div>
