@props([
    'label' => '',
    'for' => '',
    'required' => false,
    'optional' => false,
    'helpText' => '',
    'error' => '',
    'labelClass' => '',
    'fieldClass' => '',
    'class' => '',
])

<div {{ $attributes->merge(['class' => 'w-full ' . $class]) }}>
    @if($label)
        <label for="{{ $for }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 {{ $labelClass }}">
            {{ $label }}
            @if($optional)
                <span class="ml-1 text-gray-400 dark:text-gray-500">({{ __('form.optional') }})</span>
            @endif
        </label>
    @endif
    
    <div class="{{ $fieldClass }}">
        {{ $slot }}
    </div>

    @if($helpText)
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $helpText }}</p>
    @endif

    @if($error)
        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $error }}</p>
    @endif
</div> 