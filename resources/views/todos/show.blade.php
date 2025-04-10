<x-app-layout>
    <x-slot name="header">
         <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
             <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight truncate" title="{{ $todo->title }}">
                {{ __('Todo Details') }}: <span class="italic">{{ Str::limit($todo->title, 50) }}</span>
            </h2>
            <div class="flex items-center gap-x-3">
                 <a href="{{ route('todos.edit', $todo) }}" class="inline-flex items-center rounded-md bg-yellow-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-yellow-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-yellow-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-1.5 -ml-0.5">
                        <path d="M2.695 14.763l-1.262 3.154a.5.5 0 0 0 .65.65l3.155-1.262a4 4 0 0 0 1.343-.885L17.5 5.5a2.121 2.121 0 0 0-3-3L3.58 13.42a4 4 0 0 0-.885 1.343Z" />
                    </svg>
                    {{ __('Edit') }}
                </a>
                <a href="{{ url()->previous(route('todos.index')) }}" class="inline-flex items-center rounded-md bg-white dark:bg-gray-700 px-3 py-2 text-sm font-semibold text-gray-900 dark:text-gray-200 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-1.5 -ml-0.5">
                        <path fill-rule="evenodd" d="M17 10a.75.75 0 0 1-.75.75H5.612l4.158 3.96a.75.75 0 1 1-1.04 1.08l-5.5-5.25a.75.75 0 0 1 0-1.08l5.5-5.25a.75.75 0 1 1 1.04 1.08L5.612 9.25H16.25A.75.75 0 0 1 17 10Z" clip-rule="evenodd" />
                    </svg>
                    {{ __('Back') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="overflow-hidden bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        {{-- Todo Details Section --}}
        <div class="px-4 py-6 sm:px-6">
            <h3 class="text-2xl font-semibold leading-7 text-gray-900 dark:text-gray-100">{{ $todo->title }}</h3>
        </div>
        <div class="border-t border-gray-200 dark:border-gray-700">
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
        </div>

        {{-- Parent Todo Section --}}
        @if($todo->parent)
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
                    <a href="{{ route('todos.show', $todo->parent) }}" class="rounded-md bg-white dark:bg-gray-600 px-2.5 py-1.5 text-sm font-semibold text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-500 hover:bg-gray-50 dark:hover:bg-gray-500">
                        {{ __('View Parent') }}
                    </a>
                </div>
            </div>
        </div>
        @endif

        {{-- Subtasks Section --}}
        <div class="px-4 py-5 sm:px-6 border-t border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-4">
                <h3 class="text-base font-semibold leading-7 text-gray-900 dark:text-gray-100">{{ trans_choice('todo.subtasks', $todo->subtasks->count()) }} ({{ $todo->subtasks->count() }})</h3>
                 <a href="{{ route('todos.create') }}?parent_id={{ $todo->id }}" class="inline-flex items-center rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-1.5 -ml-0.5">
                        <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                    </svg>
                    {{ __('Add Subtask') }}
                </a>
            </div>
            
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
                                <a href="{{ route('todos.show', $subtask) }}" class="hidden rounded-md bg-white dark:bg-gray-600 px-2.5 py-1.5 text-sm font-semibold text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-500 hover:bg-gray-50 dark:hover:bg-gray-500 sm:block">{{ __('View') }}<span class="sr-only">, {{ $subtask->title }}</span></a>
                                <a href="{{ route('todos.edit', $subtask) }}" class="hidden rounded-md bg-yellow-50 dark:bg-yellow-600/10 px-2.5 py-1.5 text-sm font-semibold text-yellow-700 dark:text-yellow-400 shadow-sm ring-1 ring-inset ring-yellow-200 dark:ring-yellow-600/20 hover:bg-yellow-100 dark:hover:bg-yellow-600/20 sm:block">{{ __('Edit') }}<span class="sr-only">, {{ $subtask->title }}</span></a>
                           </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="rounded-md bg-blue-50 dark:bg-blue-900/50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700 dark:text-blue-300">
                                {{ __('No subtasks created yet.') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        
        {{-- Action Buttons Footer --}}
        <div class="flex items-center justify-between px-4 py-4 sm:px-6 border-t border-gray-200 dark:border-gray-700">
             <form action="{{ route('todos.destroy', $todo) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this todo and all its subtasks?') }}')">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-1.5 -ml-0.5">
                        <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z" clip-rule="evenodd" />
                    </svg>
                    {{ __('Delete Todo') }}
                </button>
            </form>
             <a href="{{ route('todos.edit', $todo) }}" class="inline-flex items-center rounded-md bg-yellow-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-yellow-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-yellow-600">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-1.5 -ml-0.5">
                    <path d="M2.695 14.763l-1.262 3.154a.5.5 0 0 0 .65.65l3.155-1.262a4 4 0 0 0 1.343-.885L17.5 5.5a2.121 2.121 0 0 0-3-3L3.58 13.42a4 4 0 0 0-.885 1.343Z" />
                </svg>
                {{ __('Edit Todo') }}
            </a>
        </div>
    </div>
</x-app-layout> 