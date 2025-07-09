@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'py-1 bg-white dark:bg-gray-700'])

















<x-ui.dropdown.menu {{ $attributes }}>
    <x-slot name="trigger">
        {{ $trigger }}
    </x-slot>
    
    {{ $slot }}
</x-ui.dropdown.menu> 