@props([

    'formControlAttributes' => '',
    'value' => '',
])

















<textarea {{ $formControlAttributes }} {{ $attributes->merge(['class' => 'shadow-sm block w-full focus:ring-teal-500 focus:border-teal-500 sm:text-sm border-gray-300 rounded-md']) }}>{{ $value ?: $slot }}</textarea>