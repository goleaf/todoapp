@props([
    'size' => null,
])









{{-- Removed redundant @php blocks and moved class logic to PHP class --}}

{{-- It's important that this file does NOT have a newline at the end. --}}
<div {{ $attributes->class([
    '[:where(&)]:text-zinc-500 [:where(&)]:dark:text-white/70',
    $computedClasses // Use the computed classes from the PHP class
])
}}>{{ $slot }}</div>