@props([
    'id',
    'title' => __('Confirm'),
    'message' => __('Are you sure you want to proceed?'),
    'confirm' => __('Confirm'),
    'cancel' => __('Cancel'),
    'confirmVariant' => 'danger',
    'form' => null
])

<x-ui.modal :id="$id" {{ $attributes }}>
    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
        <div class="sm:flex sm:items-start">
            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900 sm:mx-0 sm:h-10 sm:w-10">
                <x-ui.icon icon="heroicon-o-exclamation-triangle" class="h-6 w-6 text-red-600 dark:text-red-400" />
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
            <form id="confirmation-form-{{ $id }}" method="POST" action="{{ $form['action'] ?? '#' }}">
                @csrf
                @if($form['method'] ?? false)
                    @method($form['method'])
                @endif
                
                <x-ui.button 
                    type="submit"
                    variant="{{ $confirmVariant }}"
                    class="w-full sm:w-auto sm:ml-3"
                    x-on:click="$el.closest('dialog').close()"
                >
                    {{ $confirm }}
                </x-ui.button>
            </form>
        @else
            <x-ui.button 
                type="button"
                variant="{{ $confirmVariant }}"
                class="w-full sm:w-auto sm:ml-3"
                x-on:click="$dispatch('confirmed'); $el.closest('dialog').close()"
            >
                {{ $confirm }}
            </x-ui.button>
        @endif
        
        <x-ui.button 
            type="button"
            variant="secondary"
            class="mt-3 w-full sm:mt-0 sm:w-auto"
            x-on:click="$el.closest('dialog').close()"
        >
            {{ $cancel }}
        </x-ui.button>
    </div>
</x-ui.modal> 