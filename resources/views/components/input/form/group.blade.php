@props([
    'label' => null,
    'for' => null,
    'help' => null,
    'error' => null,
    'required' => false,
    'inline' => false,
])

<div {{ $attributes->merge(['class' => $inline ? 'sm:flex sm:items-start sm:gap-4' : '']) }}>
    @if($label)
        <div class="{{ $inline ? 'sm:w-1/3 sm:flex-none' : '' }}">
            <label for="{{ $for }}" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300">
                {{ $label }}
                @if($required)
                    <span class="text-red-500">*</span>
                @endif
            </label>
            
            @if($help)
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $help }}</p>
            @endif
        </div>
    @endif
    
    <div class="{{ $inline ? 'mt-2 sm:mt-0 sm:flex-grow' : '' }}">
        {{ $slot }}
        
        @if($error)
            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $error }}</p>
        @elseif(isset($errors) && $errors->has($for))
            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $errors->first($for) }}</p>
        @endif
    </div>
</div> 