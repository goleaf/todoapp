<x-layout.app>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-6">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Todos') }}
            </h2>
            <div class="flex items-center gap-2">
                <x-ui.tooltip text="{{ __('Click here to create a new task') }}" position="bottom">
                    <x-ui.button 
                        href="{{ route('todos.create') }}" 
                        variant="primary" 
                        size="lg" 
                        icon="heroicon-o-plus"
                        id="create-todo-btn"
                    >
                        {{ __('Create Todo') }}
                    </x-ui.button>
                </x-ui.tooltip>
                
                <x-ui.tooltip text="{{ __('View keyboard shortcuts') }}" position="bottom">
                    <x-ui.button 
                        type="button"
                        variant="secondary" 
                        size="lg" 
                        icon="heroicon-o-keyboard"
                        @click="$dispatch('keyboard-shortcuts-help-open')"
                    >
                        {{ __('Shortcuts') }}
                    </x-ui.button>
                </x-ui.tooltip>
            </div>
        </div>

        <!-- Search -->
        <div class="mb-6">
            <x-ui.tooltip text="{{ __('Type here to search for tasks') }}" position="top">
                <x-ui.search 
                    :placeholder="__('Search todos...')" 
                    :route="route('todos.index')" 
                    name="search" 
                    class="max-w-full" 
                    id="todo-search"
                />
            </x-ui.tooltip>
        </div>

        <!-- Filters -->
        <x-ui.card class="mb-6" withBorder>
            <x-slot name="header">
                <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-gray-100">{{ __('Filter Todos') }}</h3>
            </x-slot>
            
            <form method="GET" action="{{ route('todos.index') }}" class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6" id="filter-form">
                {{-- Category Filter --}}
                <div class="sm:col-span-2">
                    <x-ui.tooltip text="{{ __('Filter tasks by category') }}" position="top">
                        <x-input.form.group
                            :label="__('Category')"
                            for="category_id"
                        >
                            <x-input.select id="category_id" name="category_id" class="block w-full">
                                <option value="">{{ __('All Categories') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </x-input.select>
                        </x-input.form.group>
                    </x-ui.tooltip>
                </div>

                {{-- Status Filter --}}
                <div class="sm:col-span-2">
                    <x-ui.tooltip text="{{ __('Filter tasks by completion status') }}" position="top">
                        <x-input.form.group
                            :label="__('Status')"
                            for="status"
                        >
                            <x-input.select id="status" name="status" class="block w-full">
                                <option value="">{{ __('All Statuses') }}</option>
                                @foreach ($statuses as $key => $status)
                                    <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </x-input.select>
                        </x-input.form.group>
                    </x-ui.tooltip>
                </div>
                
                {{-- Sort By --}}
                <div class="sm:col-span-2">
                    <x-ui.tooltip text="{{ __('Choose how to order your tasks') }}" position="top">
                        <x-input.form.group
                            :label="__('Sort By')"
                            for="sort"
                        >
                            <x-input.select id="sort" name="sort" class="block w-full">
                                <option value="latest" {{ request('sort', 'latest') === 'latest' ? 'selected' : '' }}>{{ __('Newest First') }}</option>
                                <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>{{ __('Oldest First') }}</option>
                                <option value="due_asc" {{ request('sort') === 'due_asc' ? 'selected' : '' }}>{{ __('Due Date (Oldest First)') }}</option>
                                <option value="due_desc" {{ request('sort') === 'due_desc' ? 'selected' : '' }}>{{ __('Due Date (Newest First)') }}</option>
                            </x-input.select>
                        </x-input.form.group>
                    </x-ui.tooltip>
                </div>
                
                {{-- Action Buttons --}}
                <div class="sm:col-span-6 flex items-center justify-start gap-x-3 pt-2">
                    <x-ui.tooltip text="{{ __('Apply filters') }}" position="top">
                        <x-ui.button 
                            type="submit" 
                            variant="primary"
                            size="lg"
                            icon="heroicon-o-funnel"
                            id="apply-filters-btn"
                        >
                            {{ __('Filter') }}
                        </x-ui.button>
                    </x-ui.tooltip>
                    <x-ui.tooltip text="{{ __('Clear all filters') }}" position="top">
                        <x-ui.button 
                            href="{{ route('todos.index') }}" 
                            size="lg"
                            variant="secondary"
                            id="reset-filters-btn"
                        >
                            {{ __('Reset') }}
                        </x-ui.button>
                    </x-ui.tooltip>
                </div>
            </form>
        </x-ui.card>

        <!-- Todo List -->
        <x-ui.card withBorder>
            @if($todos->count() > 0)
                <x-data.table>
                    <x-slot name="header">
                        <tr>
                            <x-data.table.heading>{{ __('Title') }}</x-data.table.heading>
                            <x-data.table.heading>{{ __('Category') }}</x-data.table.heading>
                            <x-data.table.heading>{{ __('Due Date') }}</x-data.table.heading>
                            <x-data.table.heading>{{ __('Priority') }}</x-data.table.heading>
                            <x-data.table.heading>{{ __('Status') }}</x-data.table.heading>
                            <x-data.table.heading>{{ __('Subtasks') }}</x-data.table.heading>
                            <x-data.table.heading class="relative">
                                <span class="sr-only">{{ __('Actions') }}</span>
                            </x-data.table.heading>
                        </tr>
                    </x-slot>
                    
                    @foreach($todos as $todo)
                        <x-data.table.row>
                            <x-data.table.cell type="primary">{{ $todo->title }}</x-data.table.cell>
                            <x-data.table.cell>{{ $todo->category?->name ?? __('None') }}</x-data.table.cell>
                            <x-data.table.cell>{{ $todo->due_date ? $todo->due_date->translatedFormat('Y-m-d') : __('No due date') }}</x-data.table.cell>
                            <x-data.table.cell>
                                @php
                                    $priorityColors = [
                                        'low' => 'blue',
                                        'medium' => 'yellow',
                                        'high' => 'orange',
                                        'urgent' => 'red',
                                    ];
                                @endphp
                                <x-ui.badge :color="$priorityColors[$todo->priority->value]">
                                    {{ $todo->priority->name }}
                                </x-ui.badge>
                            </x-data.table.cell>
                            <x-data.table.cell>
                                @php
                                    $statusColors = [
                                        'not_started' => 'gray',
                                        'in_progress' => 'blue',
                                        'completed' => 'green',
                                        'on_hold' => 'yellow',
                                        'cancelled' => 'red',
                                    ];
                                @endphp
                                <x-ui.badge :color="$statusColors[$todo->status->value]">
                                    {{ $todo->status->name }}
                                </x-ui.badge>
                            </x-data.table.cell>
                            <x-data.table.cell>
                                @php
                                    $subtaskCount = $todo->children->count();
                                    $completedCount = $todo->children->where('status.value', 'completed')->count();
                                    $badgeColor = 'gray';
                                    
                                    if ($subtaskCount > 0) {
                                        if ($completedCount === $subtaskCount) {
                                            $badgeColor = 'green';
                                        } elseif ($completedCount > 0) {
                                            $badgeColor = 'yellow';
                                        }
                                    }
                                @endphp
                                <x-ui.badge :color="$badgeColor">
                                    {{ $completedCount }} / {{ $subtaskCount }}
                                </x-ui.badge>
                            </x-data.table.cell>
                            <x-data.table.cell class="text-right">
                                <x-ui.popover>
                                    <x-slot name="trigger">
                                        <x-ui.tooltip text="{{ __('Task options') }}" position="left">
                                            <x-ui.button variant="ghost" size="sm" icon="heroicon-o-ellipsis-horizontal" />
                                        </x-ui.tooltip>
                                    </x-slot>
                                    <x-slot name="menu">
                                        <x-ui.popover.item
                                            :href="route('todos.show', $todo)"
                                            before="heroicon-o-eye"
                                        >
                                            {{ __('View') }}
                                        </x-ui.popover.item>
                                        
                                        <x-ui.popover.item
                                            :href="route('todos.edit', $todo)"
                                            before="heroicon-o-pencil-square"
                                        >
                                            {{ __('Edit') }}
                                        </x-ui.popover.item>

                                        <x-ui.popover.item type="divider" />

                                        <x-ui.popover.item 
                                            type="button" 
                                            destructive 
                                            before="heroicon-o-trash"
                                            x-on:click="$dispatch('modal:open', 'confirm-delete-todo-{{ $todo->id }}')"
                                        >
                                            {{ __('Delete') }}
                                        </x-ui.popover.item>
                                    </x-slot>
                                </x-ui.popover>
                            </x-data.table.cell>
                        </x-data.table.row>
                        
                        <!-- Delete confirmation modal -->
                        <x-ui.modal.confirmation 
                            id="confirm-delete-todo-{{ $todo->id }}"
                            title="{{ __('Delete Todo') }}"
                            message="{{ __('Are you sure you want to delete this todo? This action cannot be undone.') }}"
                            confirm="{{ __('Delete') }}"
                            :form="[
                                'action' => route('todos.destroy', $todo),
                                'method' => 'DELETE'
                            ]"
                        />
                    @endforeach
                </x-data.table>
                
                {{-- Pagination --}}
                <div class="border-t border-gray-200 dark:border-gray-700 px-4 py-4 sm:px-6">
                    <x-data.pagination :paginator="$todos" />
                </div>
            @else
                {{-- Empty State --}}
                <x-ui.empty-state
                    title="{{ __('No todos') }}"
                    description="{{ __('Get started by creating a new todo.') }}"
                    icon="heroicon-o-clipboard-document-list"
                >
                    <x-ui.button 
                        href="{{ route('todos.create') }}" 
                        variant="primary" 
                        size="lg" 
                        icon="heroicon-o-plus"
                    >
                        {{ __('Create Todo') }}
                    </x-ui.button>
                </x-ui.empty-state>
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
                    
                    // Quick filters - status
                    case 'c':
                        document.getElementById('status').value = 'completed';
                        document.getElementById('apply-filters-btn').click();
                        break;
                    case 'p':
                        document.getElementById('status').value = 'pending';
                        document.getElementById('apply-filters-btn').click();
                        break;
                    
                    // Toggle dark mode
                    case 'd':
                        const darkModeToggleBtn = document.querySelector('[x-on\\:click="darkMode.toggle()"]');
                        if (darkModeToggleBtn) darkModeToggleBtn.click();
                        break;
                    
                    // Reset filters
                    case 'Escape':
                        document.getElementById('reset-filters-btn').click();
                        break;
                }
            };
            
            window.handleKeyboardShortcuts = handleKeyboardShortcuts;
            window.addEventListener('keydown', handleKeyboardShortcuts);
        });
    </script>
</x-slot> 