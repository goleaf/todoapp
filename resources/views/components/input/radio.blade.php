@props([
    'formControlAttributes' => '',
    'value' => ''
])







<input type="radio" {{ $formControlAttributes }} value="{{ $value }}" {{ $attributes->merge(['class' => 'h-5 w-5 text-teal-600 border-teal-300 focus:ring-teal-500']) }}>