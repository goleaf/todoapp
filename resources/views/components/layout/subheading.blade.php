@props([
    'size' => null,
])

<div {{ $attributes->class([
    $computedClasses, // Use the computed classes from the PHP class
    '[:where(&)]:text-gray-500 [:where(&)]:dark:text-white/70',
]) }} data-subheading>
    {{ $slot }}
</div>
