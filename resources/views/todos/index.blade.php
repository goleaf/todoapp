<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('My Todos') }}
            </h2>
            <a href="{{ route('todos.create') }}" class="inline-flex items-center rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">
                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-1.5 -ml-0.5">
                    <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                </svg>
                {{ __('Create New Todo') }}
            </a>
        </div>
    </x-slot>

    {{-- Filters --}}
    <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-gray-100">{{ __('Filter Todos') }}</h3>
            <form method="GET" action="{{ route('todos.index') }}" class="mt-5 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                {{-- Category Filter --}}
                <div class="sm:col-span-2">
                    <label for="category_id" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300">{{ __('Category') }}</label>
                    <div class="mt-2">
                        <select id="category_id" name="category_id" class="block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-300 dark:bg-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6">
                            <option value="">{{ __('All Categories') }}</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Status Filter --}}
                <div class="sm:col-span-2">
                    <label for="status" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300">{{ __('Status') }}</label>
                    <div class="mt-2">
                        <select id="status" name="status" class="block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-300 dark:bg-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6">
                            <option value="">{{ __('All Statuses') }}</option>
                             @foreach (App\Enums\TodoStatus::cases() as $status)
                                <option value="{{ $status->value }}" {{ request('status') == $status->value ? 'selected' : '' }}>{{ $status->label() }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                {{-- Sort By --}}
                <div class="sm:col-span-2">
                    <label for="sort" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300">{{ __('Sort By') }}</label>
                    <div class="mt-2">
                        <select id="sort" name="sort" class="block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-300 dark:bg-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6">
                            <option value="created_at" {{ request('sort', 'created_at') == 'created_at' ? 'selected' : '' }}>{{ __('Creation Date') }}</option>
                            <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>{{ __('Title') }}</option>
                            <option value="due_date" {{ request('sort') == 'due_date' ? 'selected' : '' }}>{{ __('Due Date') }}</option>
                            <option value="priority" {{ request('sort') == 'priority' ? 'selected' : '' }}>{{ __('Priority') }}</option>
                        </select>
                    </div>
                </div>
                
                {{-- Action Buttons --}}
                <div class="sm:col-span-6 flex items-center justify-start gap-x-3 pt-2">
                    <button type="submit" class="inline-flex items-center rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">
                         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-1.5 -ml-0.5">
                            <path fill-rule="evenodd" d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 0 1 .628.74v2.288a2.25 2.25 0 0 1-.659 1.59l-4.682 4.683a2.25 2.25 0 0 0-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 0 1 10 18.25v-5.757a2.25 2.25 0 0 0-.659-1.59L4.659 6.22A2.25 2.25 0 0 1 4 4.629V2.34a.75.75 0 0 1 .628-.74Z" clip-rule="evenodd" />
                        </svg>
                        {{ __('Filter') }}
                    </button>
                    <a href="{{ route('todos.index') }}" class="rounded-md bg-white dark:bg-gray-700 px-3 py-2 text-sm font-semibold text-gray-900 dark:text-gray-200 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                        {{ __('Reset') }}
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Todo List Table --}}
    <div class="overflow-hidden bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
        @if($todos->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 dark:text-gray-100 sm:pl-6">{{ __('Title') }}</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-100">{{ __('Category') }}</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-100">{{ __('Due Date') }}</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-100">{{ __('Priority') }}</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-100">{{ __('Status') }}</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-100">{{ __('Subtasks') }}</th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                <span class="sr-only">{{ __('Actions') }}</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600 bg-white dark:bg-gray-800">
                        @foreach($todos as $todo)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 dark:text-gray-100 sm:pl-6">{{ $todo->title }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $todo->category?->name ?? __('None') }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $todo->due_date ? $todo->due_date->translatedFormat('Y-m-d') : __('No due date') }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm">
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
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm">
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
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    @php $subtaskCount = $todo->subtasks_count ?? $todo->subtasks->count(); @endphp
                                    @if($subtaskCount > 0)
                                        <a href="{{ route('todos.index', ['parent_id' => $todo->id]) }}" class="inline-flex items-center rounded-md bg-gray-50 dark:bg-gray-400/10 px-2 py-1 text-xs font-medium text-gray-600 dark:text-gray-400 ring-1 ring-inset ring-gray-500/10 dark:ring-gray-400/20 hover:bg-gray-100 dark:hover:bg-gray-400/20">
                                            {{ trans_choice('todo.subtasks_count', $subtaskCount, ['count' => $subtaskCount]) }}
                                             <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-3 h-3 ml-1">
                                                <path fill-rule="evenodd" d="M4.22 11.78a.75.75 0 0 1 0-1.06L7.44 7.5 4.22 4.28a.75.75 0 1 1 1.06-1.06l3.75 3.75a.75.75 0 0 1 0 1.06l-3.75 3.75a.75.75 0 0 1-1.06 0Z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    @else
                                        0
                                    @endif
                                </td>
                                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                    <div class="flex space-x-3 justify-end">
                                        <a href="{{ route('todos.show', $todo) }}" class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-200">{{ __('View') }}</a>
                                        <a href="{{ route('todos.edit', $todo) }}" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-200">{{ __('Edit') }}</a>
                                        <form action="{{ route('todos.destroy', $todo) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this todo?') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-200">{{ __('Delete') }}</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination --}}
            <div class="border-t border-gray-200 dark:border-gray-700 px-4 py-4 sm:px-6">
                {{ $todos->links() }}
            </div>
        @else
            {{-- Empty State --}}
             <div class="text-center px-4 py-12 sm:p-16">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.25 6.75h7.5M8.25 12h7.5m-7.5 5.25h7.5M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3.75A1.75 1.75 0 0 1 4.75 2h14.5A1.75 1.75 0 0 1 21 3.75v16.5A1.75 1.75 0 0 1 19.25 22H4.75A1.75 1.75 0 0 1 3 20.25V3.75Z" />
                </svg>
                <h3 class="mt-2 text-sm font-semibold text-gray-900 dark:text-gray-100">{{ __('No todos') }}</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('Get started by creating a new todo.') }}</p>
                <div class="mt-6">
                    <a href="{{ route('todos.create') }}" class="inline-flex items-center rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">
                         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-1.5 -ml-0.5">
                            <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                        </svg>
                        {{ __('Create New Todo') }}
                    </a>
                </div>
            </div>
        @endif
    </div>
</x-app-layout> 