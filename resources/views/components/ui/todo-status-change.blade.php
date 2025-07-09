@props([

    'todo',
    'displayName' => true,
    'size' => 'md'
])

















<div 
    x-data="{
        status: '{{ $todo->status->value }}',
        originalStatus: '{{ $todo->status->value }}',
        isChanging: false,
        statusId: 'status-{{ $todo->id }}',
        
        async updateStatus(newStatus) {
            if (this.status === newStatus || this.isChanging) return;
            
            this.isChanging = true;
            
            try {
                const response = await fetch('{{ route('todos.update-status', $todo) }}', {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    },
                    body: JSON.stringify({ status: newStatus })
                });
                
                if (response.ok) {
                    const data = await response.json();
                    this.status = newStatus;
                    
                    // Animate the row if completed
                    if (newStatus === 'completed' && typeof $data.animations?.animateCheckmark === 'function') {
                        $data.animations.animateCheckmark(this.statusId, true);
                    }
                    
                    // Show toast message
                    $dispatch('toast', { 
                        message: '{{ __('messages.todo_status_updated') }}', 
                        type: 'success' 
                    });
                    
                    // If parent was updated, trigger a UI refresh
                    if (data.parentUpdated) {
                        // Refresh the parent row or dispatch event to update the parent UI
                        $dispatch('refresh-parent-todo', { parentId: data.parentId });
                    }
                } else {
                    // Get error message from response
                    let errorMessage = '{{ __('messages.todo_status_update_failed') }}';
                    try {
                        const errorData = await response.json();
                        errorMessage = errorData.message || errorMessage;
                    } catch (e) {
                        // If response is not json, use default error message
                    }
                    
                    // Show error message
                    $dispatch('toast', { 
                        message: errorMessage, 
                        type: 'error' 
                    });
                    
                    // Revert to original status
                    this.status = this.originalStatus;
                }
            } catch (error) {
                // Show generic error message for network or other failures
                $dispatch('toast', { 
                    message: '{{ __('messages.todo_status_update_error') }}', 
                    type: 'error' 
                });
                this.status = this.originalStatus;
            } finally {
                this.isChanging = false;
            }
        }
    }"
    class="todo-status-change"
>
    <div class="flex items-center space-x-2">
        <!-- Status Icon -->
        <span 
            :id="statusId"
            :class="{
                'text-gray-500 dark:text-gray-400': status === 'not_started',
                'text-blue-500 dark:text-blue-400': status === 'in_progress',
                'text-green-500 dark:text-green-400': status === 'completed',
                'text-yellow-500 dark:text-yellow-400': status === 'on_hold',
                'text-red-500 dark:text-red-400': status === 'cancelled'
            }"
        >
            <template x-if="status === 'not_started'">
                <x-ui.icon icon="{{ $iconMap['not_started'] }}" class="h-5 w-5" />
            </template>
            <template x-if="status === 'in_progress'">
                <x-ui.icon icon="{{ $iconMap['in_progress'] }}" class="h-5 w-5" />
            </template>
            <template x-if="status === 'completed'">
                <x-ui.icon icon="{{ $iconMap['completed'] }}" class="h-5 w-5" />
            </template>
            <template x-if="status === 'on_hold'">
                <x-ui.icon icon="{{ $iconMap['on_hold'] }}" class="h-5 w-5" />
            </template>
            <template x-if="status === 'cancelled'">
                <x-ui.icon icon="{{ $iconMap['cancelled'] }}" class="h-5 w-5" />
            </template>
        </span>
        
        <!-- Status Name (if displayName is true) -->
        @if($displayName)
            <span 
                class="font-medium {{ $sizeClasses[$size] }}"
                :class="{
                    'text-gray-700 dark:text-gray-300': status === 'not_started',
                    'text-blue-700 dark:text-blue-300': status === 'in_progress',
                    'text-green-700 dark:text-green-300': status === 'completed',
                    'text-yellow-700 dark:text-yellow-300': status === 'on_hold',
                    'text-red-700 dark:text-red-300': status === 'cancelled'
                }"
            >
                <span x-text="statusOptions[status]"></span>
                <span x-show="isChanging" class="inline-block animate-spin">⟳</span>
            </span>
        @endif
        
        <!-- Status Dropdown -->
        <x-ui.dropdown.menu>
            <x-slot name="trigger">
                <x-ui.button variant="ghost" size="xs" icon="heroicon-o-chevron-down" />
            </x-slot>
            <x-slot name="menu">
                @foreach($statusOptions as $value => $label)
                    <x-ui.dropdown.item 
                        type="button"
                        @click="updateStatus('{{ $value }}')"
                        :class="$value === 'completed' ? 'text-green-600 dark:text-green-400' : ''"
                    >
                        <span class="flex items-center">
                            <x-ui.icon :icon="$iconMap[$value]" class="h-4 w-4 mr-2" />
                            {{ $label }}
                        </span>
                    </x-ui.dropdown.item>
                @endforeach
            </x-slot>
        </x-ui.dropdown.menu>
    </div>
    
    <script>
        window.statusOptions = @json($statusOptions);
    </script>
</div> 