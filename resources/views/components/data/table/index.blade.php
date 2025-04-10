@props([
    'striped' => false,
    'hover' => true,
    'responsive' => true,
])

@php
    $baseClasses = 'min-w-full divide-y divide-gray-300 dark:divide-gray-700';
    $classes = $baseClasses;
@endphp

@if($responsive)
    <div class="overflow-x-auto">
@endif
    <table {{ $attributes->merge(['class' => $classes]) }}>
        @isset($header)
            <thead class="bg-gray-50 dark:bg-gray-700">
                {{ $header }}
            </thead>
        @endisset
        
        <tbody class="divide-y divide-gray-200 dark:divide-gray-600 bg-white dark:bg-gray-800">
            {{ $slot }}
        </tbody>
        
        @isset($footer)
            <tfoot class="bg-gray-50 dark:bg-gray-700">
                {{ $footer }}
            </tfoot>
        @endisset
    </table>
@if($responsive)
    </div>
@endif 