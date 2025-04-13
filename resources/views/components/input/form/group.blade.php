@props([
    'label' => null,
    'for' => null,
    'helpText' => null,
    'error' => null,
    'required' => false,
    'optional' => false
])

<div {{ $attributes->class(['space-y-2']) }}>
    @if($label)
        <div class="flex justify-between items-center">
            <label for="{{ $for }}" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">
                {{ $label }}
                @if($required)
                    <span class="ml-1 text-red-500">*</span>
                @endif
                @if($optional)
                    <span class="ml-1 text-gray-400 dark:text-gray-500">({{ __('optional') }})</span>
                @endif
            </label>
        </div>
    @endif
    
    {{ $slot }}
    
    @if($error)
        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $error }}</p>
    @elseif($helpText)
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ $helpText }}</p>
    @endif
</div> 