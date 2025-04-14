@php
use App\Helpers\TodoHelper;
@endphp

<x-layout.app :title="__('todo.todos')">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ __('todo.todos') }}</h1>
            <div class="mt-3 md:mt-0">
                <x-ui.button href="{{ route('todos.create') }}" variant="primary">
                    <x-ui.icon icon="heroicon-s-plus" class="mr-1 w-4 h-4" />
                    {{ __('todo.create') }}
                </x-ui.button>
            </div>
        </div>

        <!-- Filter and Search Card -->
        <x-ui.card class="mb-6">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('todo.filters') }}</h3>
            </div>
            <div class="border-t border-gray-200 dark:border-gray-700 px-4 py-5 sm:px-6">
                <form method="GET" action="{{ route('todos.index') }}" id="filter-form">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Search field -->
                        <div>
                            <x-input.label for="todo-search" :value="__('todo.search')" />
                            <x-input.input 
                                type="text"
                                name="search"
                                id="todo-search"
                                placeholder="{{ __('todo.search_placeholder') }}"
                                :value="request('search')"
                                class="mt-1 block w-full"
                            />
                        </div>
                        
                        <!-- Category Filter -->
                        <div>
                            <x-input.label for="category_id" :value="__('todo.category')" />
                            <x-input.select
                                id="category_id"
                                name="category_id"
                                class="mt-1 block w-full"
                            >
                                <option value="">{{ __('todo.all_categories') }}</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </x-input.select>
                        </div>
                        
                        <!-- Status Filter -->
                        <div>
                            <x-input.label for="status" :value="__('todo.status')" />
                            <x-input.select
                                id="status"
                                name="status"
                                class="mt-1 block w-full"
                            >
                                <option value="">{{ __('todo.all_statuses') }}</option>
                                <option value="not_started" {{ request('status') == 'not_started' ? 'selected' : '' }}>{{ __('todo.status_not_started') }}</option>
                                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>{{ __('todo.status_in_progress') }}</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>{{ __('todo.status_completed') }}</option>
                                <option value="on_hold" {{ request('status') == 'on_hold' ? 'selected' : '' }}>{{ __('todo.status_on_hold') }}</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>{{ __('todo.status_cancelled') }}</option>
                            </x-input.select>
                        </div>
                        
                        <!-- Priority Filter -->
                        <div>
                            <x-input.label for="priority" :value="__('todo.priority')" />
                            <x-input.select
                                id="priority"
                                name="priority"
                                class="mt-1 block w-full"
                            >
                                <option value="">{{ __('todo.all_priorities') }}</option>
                                <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>{{ __('todo.priority_low') }}</option>
                                <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>{{ __('todo.priority_medium') }}</option>
                                <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>{{ __('todo.priority_high') }}</option>
                                <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>{{ __('todo.priority_urgent') }}</option>
                            </x-input.select>
                        </div>
                        
                        <!-- Due Date Filter -->
                        <div>
                            <x-input.label for="due_date" :value="__('todo.due_date')" />
                            <x-input.select
                                id="due_date"
                                name="due_date"
                                class="mt-1 block w-full"
                            >
                                <option value="">{{ __('todo.all_due_dates') }}</option>
                                <option value="overdue" {{ request('due_date') == 'overdue' ? 'selected' : '' }}>{{ __('todo.overdue') }}</option>
                                <option value="today" {{ request('due_date') == 'today' ? 'selected' : '' }}>{{ __('todo.due_today') }}</option>
                                <option value="this_week" {{ request('due_date') == 'this_week' ? 'selected' : '' }}>{{ __('todo.due_this_week') }}</option>
                                <option value="next_week" {{ request('due_date') == 'next_week' ? 'selected' : '' }}>{{ __('todo.due_next_week') }}</option>
                                <option value="this_month" {{ request('due_date') == 'this_month' ? 'selected' : '' }}>{{ __('todo.due_this_month') }}</option>
                                <option value="no_due_date" {{ request('due_date') == 'no_due_date' ? 'selected' : '' }}>{{ __('todo.no_due_date') }}</option>
                            </x-input.select>
                        </div>
                        
                        <!-- Sort Order -->
                        <div>
                            <x-input.label for="sort" :value="__('todo.sort_by')" />
                            <x-input.select
                                id="sort"
                                name="sort"
                                class="mt-1 block w-full"
                            >
                                <option value="created_at-desc" {{ request('sort') == 'created_at-desc' ? 'selected' : '' }}>{{ __('todo.newest_first') }}</option>
                                <option value="created_at-asc" {{ request('sort') == 'created_at-asc' ? 'selected' : '' }}>{{ __('todo.oldest_first') }}</option>
                                <option value="due_date-asc" {{ request('sort') == 'due_date-asc' ? 'selected' : '' }}>{{ __('todo.due_date_asc') }}</option>
                                <option value="due_date-desc" {{ request('sort') == 'due_date-desc' ? 'selected' : '' }}>{{ __('todo.due_date_desc') }}</option>
                                <option value="title-asc" {{ request('sort') == 'title-asc' ? 'selected' : '' }}>{{ __('todo.title_a_z') }}</option>
                                <option value="title-desc" {{ request('sort') == 'title-desc' ? 'selected' : '' }}>{{ __('todo.title_z_a') }}</option>
                                <option value="priority-desc" {{ request('sort') == 'priority-desc' ? 'selected' : '' }}>{{ __('todo.priority_high_low') }}</option>
                                <option value="priority-asc" {{ request('sort') == 'priority-asc' ? 'selected' : '' }}>{{ __('todo.priority_low_high') }}</option>
                            </x-input.select>
                        </div>
                    </div>
                    
                    <div class="mt-4 flex justify-end">
                        <x-ui.button type="button" variant="secondary" href="{{ route('todos.index') }}" class="mr-2">
                            {{ __('todo.reset_filters') }}
                        </x-ui.button>
                        <x-ui.button type="submit" variant="primary" id="apply-filters-btn">
                            {{ __('todo.apply_filters') }}
                        </x-ui.button>
                    </div>
                </form>
            </div>
        </x-ui.card>

        <!-- Todo List Card -->
        <x-ui.card>
            @if (count($todos) > 0)
                <x-data.table>
                    <x-slot name="header">
                        <tr>
                            <x-data.table.heading>{{ __('todo.title') }}</x-data.table.heading>
                            <x-data.table.heading>{{ __('todo.category') }}</x-data.table.heading>
                            <x-data.table.heading>{{ __('todo.due_date') }}</x-data.table.heading>
                            <x-data.table.heading>{{ __('todo.priority') }}</x-data.table.heading>
                            <x-data.table.heading>{{ __('todo.status') }}</x-data.table.heading>
                            <x-data.table.heading>{{ __('todo.subtasks') }}</x-data.table.heading>
                            <x-data.table.heading>
                                <span class="sr-only">{{ __('todo.actions') }}</span>
                            </x-data.table.heading>
                        </tr>
                    </x-slot>
                    
                    @foreach($todos as $todo)
                        <x-data.table.row>
                            <x-data.table.cell type="primary">{{ $todo->title }}</x-data.table.cell>
                            <x-data.table.cell>{{ $todo->category?->name ?? __('todo.category_none') }}</x-data.table.cell>
                            <x-data.table.cell>{{ $todo->due_date ? $todo->due_date->translatedFormat('Y-m-d') : __('todo.no_due_date') }}</x-data.table.cell>
                            <x-data.table.cell>
                                @php
                                    $priorityColors = TodoHelper::getPriorityColors();
                                @endphp
                                <x-ui.badge :color="$priorityColors[$todo->priority->value]">
                                    {{ $todo->priority->label() }}
                                </x-ui.badge>
                            </x-data.table.cell>
                            <x-data.table.cell>
                                <x-ui.todo-status-change :todo="$todo" />
                            </x-data.table.cell>
                            <x-data.table.cell>
                                @php
                                    $subtaskCounts = TodoHelper::getSubtaskCounts($todo);
                                    $badgeColor = TodoHelper::getSubtaskBadgeColor($todo);
                                @endphp
                                <x-ui.badge :color="$badgeColor">
                                    {{ $subtaskCounts['completed'] }} / {{ $subtaskCounts['total'] }}
                                </x-ui.badge>
                            </x-data.table.cell>
                            <x-data.table.cell class="text-right">
                                <x-ui.popover>
                                    <x-slot name="trigger">
                                        <x-ui.tooltip text="{{ __('todo.task_options_tooltip') }}" position="left">
                                            <x-ui.button variant="ghost" size="sm" icon="heroicon-o-ellipsis-horizontal" />
                                        </x-ui.tooltip>
                                    </x-slot>
                                    <x-slot name="menu">
                                        <x-ui.popover.item
                                            :href="route('todos.show', $todo)"
                                            before="heroicon-o-eye"
                                        >
                                            {{ __('todo.view_action') }}
                                        </x-ui.popover.item>
                                        
                                        <x-ui.popover.item
                                            :href="route('todos.edit', $todo)"
                                            before="heroicon-o-pencil-square"
                                        >
                                            {{ __('todo.edit') }}
                                        </x-ui.popover.item>

                                        <x-ui.popover.item type="divider" />

                                        <x-ui.popover.item 
                                            type="button" 
                                            destructive 
                                            before="heroicon-o-trash"
                                            x-on:click="$dispatch('modal:open', 'confirm-delete-todo-{{ $todo->id }}')"
                                        >
                                            {{ __('todo.delete') }}
                                        </x-ui.popover.item>
                                    </x-slot>
                                </x-ui.popover>
                            </x-data.table.cell>
                        </x-data.table.row>
                        
                        <!-- Delete confirmation modal -->
                        <x-ui.modal.confirmation 
                            id="confirm-delete-todo-{{ $todo->id }}"
                            title="{{ __('todo.delete') }}"
                            message="{{ __('todo.delete_confirm_message') }}"
                            confirm="{{ __('todo.delete') }}"
                            :form="[
                                'action' => route('todos.destroy', $todo),
                                'method' => 'DELETE'
                            ]"
                        />
                    @endforeach
                    
                </x-data.table>

                <div class="mt-6">
                    {{ $todos->appends(request()->query())->links() }}
                </div>
            @else
                <div class="py-10 text-center">
                    @if(request()->hasAny(['search', 'category_id', 'status']))
                        <x-ui.empty-state 
                            icon="heroicon-o-magnifying-glass" 
                            title="{{ __('todo.empty_title_filtered') }}"
                            description="{{ __('todo.empty_description_filtered') }}"
                        />
                    @else
                        <x-ui.empty-state 
                            icon="heroicon-o-clipboard-document-list" 
                            title="{{ __('todo.empty_title_no_todos') }}" 
                            description="{{ __('todo.empty_description_create_first') }}" 
                        >
                            <x-slot name="actions">
                                <x-ui.button href="{{ route('todos.create') }}" variant="primary">{{ __('todo.create') }}</x-ui.button>
                            </x-slot>
                        </x-ui.empty-state>
                    @endif
                </div>
            @endif
        </x-ui.card>
    </div>
</x-layout.app>

<!-- Include keyboard shortcuts help component -->
<x-ui.keyboard-shortcuts-help />

<x-slot name="scripts">
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Show success message if redirected after action
            @if (session('success'))
                window.dispatchEvent(new CustomEvent('toast-success', {
                    detail: {
                        message: "{{ session('success') }}"
                    }
                }));
            @endif
            
            @if (session('error'))
                window.dispatchEvent(new CustomEvent('toast-error', {
                    detail: {
                        message: "{{ session('error') }}"
                    }
                }));
            @endif
            
            // Keyboard shortcuts handling
            const handleKeyboardShortcuts = (event) => {
                // Skip when input elements are focused
                if (event.target.matches('input, textarea, select') || 
                    event.ctrlKey || event.metaKey || event.altKey) {
                    return;
                }
                
                // Handle keyboard shortcuts
                switch (event.key) {
                    // Navigation
                    case 'g':
                        // Wait for next key
                        document.addEventListener('keydown', function navHandler(e) {
                            document.removeEventListener('keydown', navHandler);
                            if (e.key === 'h') window.location.href = '{{ route('home') }}';
                            else if (e.key === 't') window.location.href = '{{ route('todos.index') }}';
                            else if (e.key === '?') window.location.href = '{{ route('help') }}';
                        });
                        break;
                    
                    // Show keyboard shortcuts
                    case '?':
                        window.dispatchEvent(new CustomEvent('keyboard-shortcuts-help-open'));
                        break;
                    
                    // Create new todo
                    case 'n':
                        window.location.href = '{{ route('todos.create') }}';
                        break;
                    
                    // Focus search
                    case 'f':
                        document.getElementById('todo-search').focus();
                        event.preventDefault();
                        break;
                    
                    // Quick filters - priority
                    case '1':
                        document.getElementById('priority').value = 'low';
                        document.getElementById('apply-filters-btn').click();
                        break;
                    case '2':
                        document.getElementById('priority').value = 'medium';
                        document.getElementById('apply-filters-btn').click();
                        break;
                    case '3':
                        document.getElementById('priority').value = 'high';
                        document.getElementById('apply-filters-btn').click();
                        break;
                    case '4':
                        document.getElementById('priority').value = 'urgent';
                        document.getElementById('apply-filters-btn').click();
                        break;
                }
            };
            
            document.addEventListener('keydown', handleKeyboardShortcuts);
        });
    </script>
</x-slot> 