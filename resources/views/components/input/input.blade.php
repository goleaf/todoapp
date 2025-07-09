@props([
    'formControlAttributes' => '',
    'size' => 'base',
    'label' => null,
    'id' => null,
    'value' => '',
    'type' => 'text',
])

<div class="mb-4">
    @if($label)
        <x-input.label :for="$id">{{ $label }}</x-input.label>
    @endif
    
    <input
        type="{{ $type }}"
        id="{{ $id }}"
        value="{{ $value }}"
        {{ $attributes->merge(['class' => 'block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-gray-700 dark:text-white dark:ring-gray-600']) }}
    />
</div> 