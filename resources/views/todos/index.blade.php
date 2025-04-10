<x-layout.app>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('My Todos') }}
            </h2>
            <x-ui.button 
                href="{{ route('todos.create') }}" 
                :icon="app('heroicon')->outline('plus')"
                variant="primary"
            >
                {{ __('Create New Todo') }}
            </x-ui.button>
        </div>
    </x-slot>

    {{-- Filters Card --}}
    <x-ui.card class="mb-6" withBorder>
        <x-slot name="header">
            <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-gray-100">{{ __('Filter Todos') }}</h3>
        </x-slot>
        
        <form method="GET" action="{{ route('todos.index') }}" class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
            {{-- Category Filter --}}
            <div class="sm:col-span-2">
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
            </div>

            {{-- Status Filter --}}
            <div class="sm:col-span-2">
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
            </div>
            
            {{-- Sort By --}}
            <div class="sm:col-span-2">
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
            </div>
            
            {{-- Action Buttons --}}
            <div class="sm:col-span-6 flex items-center justify-start gap-x-3 pt-2">
                <x-ui.button 
                    type="submit" 
                    variant="primary"
                    :icon="app('heroicon')->outline('funnel')"
                >
                    {{ __('Filter') }}
                </x-ui.button>
                <x-ui.button 
                    href="{{ route('todos.index') }}" 
                    variant="secondary"
                >
                    {{ __('Reset') }}
                </x-ui.button>
            </div>
        </form>
    </x-ui.card>

    {{-- Todo List Table Card --}}
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
                                    App\Enums\TodoPriority::HIGH->value => 'red',
                                    App\Enums\TodoPriority::MEDIUM->value => 'yellow',
                                    App\Enums\TodoPriority::LOW->value => 'blue',
                                ];
                            @endphp
                            <x-ui.badge :color="$priorityColors[$todo->priority->value]">
                                {{ $todo->priority->label() }}
                            </x-ui.badge>
                        </x-data.table.cell>
                        <x-data.table.cell>
                            @php
                                $statusColors = [
                                    App\Enums\TodoStatus::COMPLETED->value => 'green',
                                    App\Enums\TodoStatus::IN_PROGRESS->value => 'blue',
                                    App\Enums\TodoStatus::PENDING->value => 'gray',
                                ];
                            @endphp
                            <x-ui.badge :color="$statusColors[$todo->status->value]">
                                {{ $todo->status->label() }}
                            </x-ui.badge>
                        </x-data.table.cell>
                        <x-data.table.cell>
                            @php $subtaskCount = $todo->subtasks_count ?? $todo->subtasks->count(); @endphp
                            @if($subtaskCount > 0)
                                <a href="{{ route('todos.index', ['parent_id' => $todo->id]) }}" class="inline-flex items-center hover:underline">
                                    <x-ui.badge 
                                        :icon="app('heroicon')->outline('clipboard-document-list')" 
                                        color="gray"
                                    >
                                        {{ trans_choice('todo.subtasks_count', $subtaskCount, ['count' => $subtaskCount]) }}
                                    </x-ui.badge>
                                </a>
                            @else
                                0
                            @endif
                        </x-data.table.cell>
                        <x-data.table.cell type="action">
                            <div class="flex items-center justify-end space-x-3">
                                <x-ui.dropdown.menu>
                                    <x-slot name="trigger">
                                        <button type="button" class="flex items-center text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 focus:outline-none">
                                            <x-ui.icon.heroicon-s-ellipsis-vertical class="h-5 w-5" />
                                        </button>
                                    </x-slot>

                                    <x-ui.dropdown.item 
                                        type="link" 
                                        href="{{ route('todos.show', $todo) }}" 
                                        :icon="app('heroicon')->outline('eye')"
                                    >
                                        {{ __('View') }}
                                    </x-ui.dropdown.item>
                                    <x-ui.dropdown.item 
                                        type="link" 
                                        href="{{ route('todos.edit', $todo) }}" 
                                        :icon="app('heroicon')->outline('pencil-square')"
                                    >
                                        {{ __('Edit') }}
                                    </x-ui.dropdown.item>
                                    <x-ui.dropdown.item type="divider" />
                                    <form action="{{ route('todos.destroy', $todo) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <x-ui.dropdown.item 
                                            type="submit" 
                                            destructive
                                            :icon="app('heroicon')->outline('trash')"
                                            onclick="return confirm('{{ __('Are you sure you want to delete this todo?') }}')"
                                        >
                                            {{ __('Delete') }}
                                        </x-ui.dropdown.item>
                                    </form>
                                </x-ui.dropdown.menu>
                            </div>
                        </x-data.table.cell>
                    </x-data.table.row>
                @endforeach
            </x-data.table>
            
            {{-- Pagination --}}
            <div class="border-t border-gray-200 dark:border-gray-700 px-4 py-4 sm:px-6">
                {{ $todos->links() }}
            </div>
        @else
            {{-- Empty State --}}
            <x-ui.empty-state
                title="{{ __('No todos') }}"
                description="{{ __('Get started by creating a new todo.') }}"
                :icon="app('heroicon')->outline('clipboard-document-list')"
            >
                <x-ui.button 
                    href="{{ route('todos.create') }}" 
                    :icon="app('heroicon')->outline('plus')"
                    variant="primary"
                >
                    {{ __('Create New Todo') }}
                </x-ui.button>
            </x-ui.empty-state>
        @endif
    </x-ui.card>
</x-layout.app> 