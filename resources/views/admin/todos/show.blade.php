<x-layout.app>
    <x-slot name="header">
         <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight truncate" title="{{ $todo->title }}">
                {{ __('Admin - Todo Details') }}: <span class="italic">{{ Str::limit($todo->title, 50) }}</span>
            </h2>
            <div class="flex items-center gap-x-3">
                <x-ui.button 
                    href="{{ route('admin.todos.edit', $todo) }}" 
                    variant="warning" 
                    size="sm" 
                    :icon="app('heroicon')->outline('pencil-square')"
                >
                    {{ __('Edit') }}
                </x-ui.button>
                <x-ui.button 
                    href="{{ route('admin.todos.index') }}" 
                    variant="secondary" 
                    size="sm" 
                    :icon="app('heroicon')->outline('arrow-left')"
                >
                    {{ __('Back to Todos') }}
                </x-ui.button>
            </div>
        </div>
    </x-slot>

    <x-ui.card>
        {{-- Todo Details Section --}}
        <x-slot name="header">
            <h3 class="text-2xl font-semibold leading-7 text-gray-900 dark:text-gray-100">{{ $todo->title }}</h3>
             <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500 dark:text-gray-400">{{ __('Details for todo ID:') }} {{ $todo->id }}</p>
        </x-slot>
        
        <dl class="divide-y divide-gray-200 dark:divide-gray-700">
            <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('User') }}</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300 sm:col-span-2 sm:mt-0">
                    {{-- Optional: Link to admin user view --}}
                     <a href="{{ route('admin.users.show', $todo->user) }}" class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-200 underline">
                        {{ $todo->user->name }} ({{ $todo->user->email }})
                    </a>
                </dd>
            </div>
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
             @if($todo->parent)
            <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('Parent Todo') }}</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300 sm:col-span-2 sm:mt-0">
                     <a href="{{ route('admin.todos.show', $todo->parent) }}" class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-200 underline">
                        {{ $todo->parent->title }} (ID: {{ $todo->parent->id }})
                    </a>
                </dd>
            </div>
            @endif
        </dl>
    </x-ui.card>

    {{-- Subtasks Section --}}
    <x-ui.card class="mt-6">
        <x-slot name="header">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <h3 class="text-base font-semibold leading-7 text-gray-900 dark:text-gray-100">{{ trans_choice('todo.subtasks', $todo->subtasks->count()) }} ({{ $todo->subtasks->count() }})</h3>
                {{-- Optional: Add Subtask button if Admins can add subtasks via admin panel --}}
                {{-- <x-ui.button 
                    href="{{ route('admin.todos.create') }}?parent_id={{ $todo->id }}" 
                    variant="primary" 
                    size="sm" 
                    :icon="app('heroicon')->outline('plus')"
                >
                    {{ __('Add Subtask') }}
                </x-ui.button> --}}
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
                                href="{{ route('admin.todos.show', $subtask) }}" 
                                variant="secondary" 
                                size="xs" 
                                class="hidden sm:block"
                            >
                                {{ __('View') }}<span class="sr-only">, {{ $subtask->title }}</span>
                            </x-ui.button>
                            <x-ui.button 
                                href="{{ route('admin.todos.edit', $subtask) }}" 
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
                         <x-ui.icon.heroicon-o-information-circle class="h-5 w-5 text-blue-400" />
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700 dark:text-blue-300">
                            {{ __('This todo has no subtasks.') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif
        
        <x-slot name="footer">
            <div class="flex items-center justify-between">
                <form action="{{ route('admin.todos.destroy', $todo) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this todo and all its subtasks?') }}')">
                    @csrf
                    @method('DELETE')
                    <x-ui.button 
                        type="submit" 
                        variant="danger" 
                        size="sm" 
                        :icon="app('heroicon')->outline('trash')"
                    >
                        {{ __('Delete Todo') }}
                    </x-ui.button>
                </form>
                <x-ui.button 
                    href="{{ route('admin.todos.edit', $todo) }}" 
                    variant="warning" 
                    size="sm" 
                    :icon="app('heroicon')->outline('pencil-square')"
                >
                    {{ __('Edit Todo') }}
                </x-ui.button>
            </div>
        </x-slot>
    </x-ui.card>
</x-layout.app> 