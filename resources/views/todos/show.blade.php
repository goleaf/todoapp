<x-layout.app>
    <x-slot name="header">
         <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
             <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight truncate" title="{{ $todo->title }}">
                {{ __('Todo Details') }}: <span class="italic">{{ Str::limit($todo->title, 50) }}</span>
            </h2>
            <div class="flex items-center gap-x-3">
                <x-ui.button 
                    href="{{ route('todos.edit', $todo) }}" 
                    variant="warning" 
                    size="sm" 
                    icon="heroicon-o-pencil-square"
                >
                    {{ __('Edit') }}
                </x-ui.button>
                <x-ui.button 
                    href="{{ url()->previous(route('todos.index')) }}" 
                    variant="secondary" 
                    size="sm" 
                    icon="heroicon-o-arrow-left"
                >
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </x-slot>

    <x-ui.card>
        {{-- Todo Details Section --}}
        <x-slot name="header">
            <h3 class="text-2xl font-semibold leading-7 text-gray-900 dark:text-gray-100">{{ $todo->title }}</h3>
        </x-slot>
        
        <dl class="divide-y divide-gray-200 dark:divide-gray-700">
             <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('Status') }}</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300 sm:col-span-2 sm:mt-0">
                     <span @class([
                        'inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset',
                         match ($todo->status) {
                            App\Enums\TodoStatus::COMPLETED => 'bg-green-50 dark:bg-green-400/10 text-green-700 dark:text-green-400 ring-green-600/20 dark:ring-green-400/20',
                            App\Enums\TodoStatus::IN_PROGRESS => 'bg-blue-50 dark:bg-blue-400/10 text-blue-700 dark:text-blue-400 ring-blue-700/10 dark:ring-blue-400/30',
                            App\Enums\TodoStatus::PENDING => 'bg-gray-50 dark:bg-gray-400/10 text-gray-600 dark:text-gray-400 ring-gray-500/10 dark:ring-gray-400/20',
                        }
                    ])>
                        {{ $todo->status->label() }}
                    </span>
                </dd>
            </div>
             <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('Priority') }}</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300 sm:col-span-2 sm:mt-0">
                    <span @class([
                        'inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset',
                        match ($todo->priority) {
                            App\Enums\TodoPriority::HIGH => 'bg-red-50 dark:bg-red-400/10 text-red-700 dark:text-red-400 ring-red-600/10 dark:ring-red-400/20',
                            App\Enums\TodoPriority::MEDIUM => 'bg-yellow-50 dark:bg-yellow-400/10 text-yellow-800 dark:text-yellow-500 ring-yellow-600/20 dark:ring-yellow-400/20',
                            App\Enums\TodoPriority::LOW => 'bg-blue-50 dark:bg-blue-400/10 text-blue-700 dark:text-blue-400 ring-blue-700/10 dark:ring-blue-400/30',
                        }
                    ])>
                        {{ $todo->priority->label() }}
                    </span>
                </dd>
            </div>
             <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('Category') }}</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300 sm:col-span-2 sm:mt-0">
                    {{ $todo->category?->name ?? __('None') }}
                </dd>
            </div>
             <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('Due Date') }}</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300 sm:col-span-2 sm:mt-0">
                    {{ $todo->due_date ? $todo->due_date->translatedFormat('Y-m-d') : __('No due date') }}
                </dd>
            </div>
             <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('Created') }}</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300 sm:col-span-2 sm:mt-0" title="{{ $todo->created_at->translatedFormat('Y-m-d H:i:s') }}">
                    {{ $todo->created_at->diffForHumans() }}
                </dd>
            </div>
             <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('Last Updated') }}</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300 sm:col-span-2 sm:mt-0" title="{{ $todo->updated_at->translatedFormat('Y-m-d H:i:s') }}">
                     {{ $todo->updated_at->diffForHumans() }}
                </dd>
            </div>
            @if($todo->description)
            <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('Description') }}</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300 sm:col-span-2 sm:mt-0">
                    <p class="whitespace-pre-line">{{ $todo->description }}</p>
                </dd>
            </div>
            @endif
        </dl>

        {{-- Parent Todo Section --}}
        @if($todo->parent)
        <x-slot name="footer">
            <div class="px-4 py-5 sm:px-6 border-t border-gray-200 dark:border-gray-700">
                <h3 class="text-base font-semibold leading-7 text-gray-900 dark:text-gray-100 mb-4">{{ __('Parent Todo') }}</h3>
                <div class="rounded-md border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-medium text-gray-900 dark:text-gray-100">{{ $todo->parent->title }}</p>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                <span @class([
                                    'inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset',
                                    match ($todo->parent->status) {
                                        App\Enums\TodoStatus::COMPLETED => 'bg-green-50 dark:bg-green-400/10 text-green-700 dark:text-green-400 ring-green-600/20 dark:ring-green-400/20',
                                        App\Enums\TodoStatus::IN_PROGRESS => 'bg-blue-50 dark:bg-blue-400/10 text-blue-700 dark:text-blue-400 ring-blue-700/10 dark:ring-blue-400/30',
                                        App\Enums\TodoStatus::PENDING => 'bg-gray-50 dark:bg-gray-400/10 text-gray-600 dark:text-gray-400 ring-gray-500/10 dark:ring-gray-400/20',
                                    }
                                ])>
                                    {{ $todo->parent->status->label() }}
                                </span>
                                 <span @class([
                                    'ml-2 inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset',
                                    match ($todo->parent->priority) {
                                        App\Enums\TodoPriority::HIGH => 'bg-red-50 dark:bg-red-400/10 text-red-700 dark:text-red-400 ring-red-600/10 dark:ring-red-400/20',
                                        App\Enums\TodoPriority::MEDIUM => 'bg-yellow-50 dark:bg-yellow-400/10 text-yellow-800 dark:text-yellow-500 ring-yellow-600/20 dark:ring-yellow-400/20',
                                        App\Enums\TodoPriority::LOW => 'bg-blue-50 dark:bg-blue-400/10 text-blue-700 dark:text-blue-400 ring-blue-700/10 dark:ring-blue-400/30',
                                    }
                                ])>
                                    {{ $todo->parent->priority->label() }}
                                </span>
                            </p>
                        </div>
                        <x-ui.button 
                            href="{{ route('todos.show', $todo->parent) }}" 
                            variant="secondary" 
                            size="sm"
                        >
                            {{ __('View Parent') }}
                        </x-ui.button>
                    </div>
                </div>
            </div>
        </x-slot>
        @endif
    </x-ui.card>

    {{-- Subtasks Section --}}
    <x-ui.card class="mt-6">
        <x-slot name="header">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <h3 class="text-base font-semibold leading-7 text-gray-900 dark:text-gray-100">{{ trans_choice('todo.subtasks', $todo->subtasks->count()) }} ({{ $todo->subtasks->count() }})</h3>
                <x-ui.button 
                    href="{{ route('todos.create') }}?parent_id={{ $todo->id }}" 
                    variant="primary" 
                    size="sm" 
                    icon="heroicon-o-plus"
                >
                    {{ __('Add Subtask') }}
                </x-ui.button>
            </div>
        </x-slot>
        
        @if($todo->subtasks->count() > 0)
            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700 rounded-md border border-gray-200 dark:border-gray-700">
                @foreach($todo->subtasks as $subtask)
                    <li class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-x-6 gap-y-3 py-4 px-4 text-sm leading-6">
                        <div class="flex flex-1 items-center gap-x-3">
                             <span @class([
                                'truncate font-medium',
                                'text-gray-900 dark:text-gray-100',
                                'line-through text-gray-500 dark:text-gray-400' => $subtask->status === App\Enums\TodoStatus::COMPLETED
                            ])>{{ $subtask->title }}</span>
                        </div>
                        <div class="flex flex-none items-center gap-x-4">
                            <span @class([
                                'inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset',
                                match ($subtask->status) {
                                    App\Enums\TodoStatus::COMPLETED => 'bg-green-50 dark:bg-green-400/10 text-green-700 dark:text-green-400 ring-green-600/20 dark:ring-green-400/20',
                                    App\Enums\TodoStatus::IN_PROGRESS => 'bg-blue-50 dark:bg-blue-400/10 text-blue-700 dark:text-blue-400 ring-blue-700/10 dark:ring-blue-400/30',
                                    App\Enums\TodoStatus::PENDING => 'bg-gray-50 dark:bg-gray-400/10 text-gray-600 dark:text-gray-400 ring-gray-500/10 dark:ring-gray-400/20',
                                }
                            ])>
                                {{ $subtask->status->label() }}
                            </span>
                            <span @class([
                                'hidden sm:inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset',
                                match ($subtask->priority) {
                                    App\Enums\TodoPriority::HIGH => 'bg-red-50 dark:bg-red-400/10 text-red-700 dark:text-red-400 ring-red-600/10 dark:ring-red-400/20',
                                    App\Enums\TodoPriority::MEDIUM => 'bg-yellow-50 dark:bg-yellow-400/10 text-yellow-800 dark:text-yellow-500 ring-yellow-600/20 dark:ring-yellow-400/20',
                                    App\Enums\TodoPriority::LOW => 'bg-blue-50 dark:bg-blue-400/10 text-blue-700 dark:text-blue-400 ring-blue-700/10 dark:ring-blue-400/30',
                                }
                            ])>
                                {{ $subtask->priority->label() }}
                            </span>
                            @if($subtask->due_date)
                                <span class="hidden sm:inline text-xs text-gray-500 dark:text-gray-400">{{ __('Due') }}: {{ $subtask->due_date->translatedFormat('Y-m-d') }}</span>
                            @endif
                            <x-ui.button 
                                href="{{ route('todos.show', $subtask) }}" 
                                variant="secondary" 
                                size="xs" 
                                class="hidden sm:block"
                            >
                                {{ __('View') }}<span class="sr-only">, {{ $subtask->title }}</span>
                            </x-ui.button>
                            <x-ui.button 
                                href="{{ route('todos.edit', $subtask) }}" 
                                variant="warning" 
                                size="xs" 
                                class="hidden sm:block"
                            >
                                {{ __('Edit') }}<span class="sr-only">, {{ $subtask->title }}</span>
                            </x-ui.button>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="rounded-md bg-blue-50 dark:bg-blue-900/50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <x-ui.icon icon="heroicon-o-information-circle" class="h-5 w-5 text-blue-400" />
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700 dark:text-blue-300">
                            {{ __('No subtasks created yet.') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif
        
        <x-slot name="footer">
            <div class="flex items-center justify-between">
                <x-ui.button 
                    type="button" 
                    variant="danger" 
                    size="sm" 
                    icon="heroicon-o-trash"
                    x-on:click="$dispatch('modal:open', 'confirm-delete-todo')"
                >
                    {{ __('Delete Todo') }}
                </x-ui.button>
                <x-ui.button 
                    href="{{ route('todos.edit', $todo) }}" 
                    variant="warning" 
                    size="sm" 
                    icon="heroicon-o-pencil-square"
                >
                    {{ __('Edit Todo') }}
                </x-ui.button>
            </div>
        </x-slot>
    </x-ui.card>

    <!-- Delete confirmation modal -->
    <x-ui.modal.confirmation 
        id="confirm-delete-todo"
        title="{{ __('Delete Todo') }}"
        message="{{ __('Are you sure you want to delete this todo and all its subtasks? This action cannot be undone.') }}"
        confirm="{{ __('Delete') }}"
        :form="[
            'action' => route('todos.destroy', $todo),
            'method' => 'DELETE'
        ]"
    />
</x-layout.app> 