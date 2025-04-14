@props([
    'id',
    'title' => __('Confirm'),
    'message' => __('Are you sure you want to proceed?'),
    'confirm' => __('Confirm'),
    'cancel' => __('Cancel'),
    'confirmVariant' => 'danger',
    'form' => null
])

<x-ui.modal :id="$id" {{ $attributes }} 
    x-data="{ 
        isLoading: false,
        showWarningAnimation() {
            if (typeof $data.animations?.shakeElement === 'function') {
                $data.animations.shakeElement('warning-icon-{{ $id }}');
            }
        }
    }"
    x-init="showWarningAnimation()">
    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
        <div class="sm:flex sm:items-start">
            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900 sm:mx-0 sm:h-10 sm:w-10">
                <x-ui.icon id="warning-icon-{{ $id }}" icon="heroicon-o-exclamation-triangle" class="h-6 w-6 text-red-600 dark:text-red-400" />
            </div>
            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">
                    {{ $title }}
                </h3>
                <div class="mt-2">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $message }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
        @if($form)
            <form id="confirmation-form-{{ $id }}" method="POST" action="{{ $form['action'] ?? '#' }}"
                x-on:submit="isLoading = true">
                @csrf
                @if($form['method'] ?? false)
                    @method($form['method'])
                @endif
                
                <x-ui.button 
                    type="submit"
                    variant="{{ $confirmVariant }}"
                    class="w-full sm:w-auto sm:ml-3"
                    x-bind:disabled="isLoading"
                    x-bind:class="{ 'opacity-75 cursor-not-allowed': isLoading }"
                >
                    <span x-show="!isLoading">{{ $confirm }}</span>
                    <span x-show="isLoading" class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        {{ __('Processing...') }}
                    </span>
                </x-ui.button>
            </form>
        @else
            <x-ui.button 
                type="button"
                variant="{{ $confirmVariant }}"
                class="w-full sm:w-auto sm:ml-3"
                x-on:click="$dispatch('confirmed'); $el.closest('dialog').close()"
                x-bind:disabled="isLoading"
                x-bind:class="{ 'opacity-75 cursor-not-allowed': isLoading }"
            >
                {{ $confirm }}
            </x-ui.button>
        @endif
        
        <x-ui.button 
            type="button"
            variant="secondary"
            class="mt-3 w-full sm:mt-0 sm:w-auto"
            x-on:click="$el.closest('dialog').close()"
            x-bind:disabled="isLoading"
            x-bind:class="{ 'opacity-75 cursor-not-allowed': isLoading }"
        >
            {{ $cancel }}
        </x-ui.button>
    </div>
</x-ui.modal> 