<x-layout.app>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center">
                <span class="inline-block w-4 h-4 rounded-full mr-2" style="background-color: {{ $category->color }}"></span>
                {{ $category->name }}
            </h2>
            <div class="flex gap-2">
                <x-ui.button
                    href="{{ route('categories.edit', $category) }}"
                    variant="warning"
                    size="sm"
                    icon="heroicon-o-pencil"
                >
                    {{ __('Edit Category') }}
                </x-ui.button>
                <x-ui.button
                    href="{{ route('categories.index') }}"
                    variant="secondary"
                    size="sm"
                    icon="heroicon-o-arrow-left"
                >
                    {{ __('Back to Categories') }}
                </x-ui.button>
            </div>
        </div>
    </x-slot>

    <x-ui.container>
        <div class="py-12">
            <x-feedback.action-message class="mb-4" :status="session('status')" />

            @if($category->description)
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-2">{{ __('About this category') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400">{{ $category->description }}</p>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6 mb-6">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                        {{ __('Todos in this category') }} ({{ $todos->total() }})
                    </h3>
                    <x-ui.button
                        href="{{ route('todos.create', ['category_id' => $category->id]) }}"
                        variant="primary"
                        size="sm"
                        icon="heroicon-o-plus"
                    >
                        {{ __('Add Todo to this Category') }}
                    </x-ui.button>
                </div>

                @if($todos->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('Title') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('Status') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('Priority') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('Due Date') }}
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">{{ __('Actions') }}</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($todos as $todo)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('todos.show', $todo) }}" class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">
                                                {{ $todo->title }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span class="px-2 py-1 text-xs rounded-full
                                                @if($todo->status == \App\Enums\TodoStatus::COMPLETED)
                                                    bg-green-100 text-green-800 dark:bg-green-800/20 dark:text-green-400
                                                @elseif($todo->status == \App\Enums\TodoStatus::IN_PROGRESS)
                                                    bg-blue-100 text-blue-800 dark:bg-blue-800/20 dark:text-blue-400
                                                @else
                                                    bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                                @endif
                                            ">
                                                {{ $todo->status->label() }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span class="px-2 py-1 text-xs rounded-full
                                                @if($todo->priority == \App\Enums\TodoPriority::HIGH)
                                                    bg-red-100 text-red-800 dark:bg-red-800/20 dark:text-red-400
                                                @elseif($todo->priority == \App\Enums\TodoPriority::MEDIUM)
                                                    bg-yellow-100 text-yellow-800 dark:bg-yellow-800/20 dark:text-yellow-400
                                                @else
                                                    bg-blue-100 text-blue-800 dark:bg-blue-800/20 dark:text-blue-400
                                                @endif
                                            ">
                                                {{ $todo->priority->label() }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $todo->due_date ? $todo->due_date->format('M d, Y') : __('No due date') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end space-x-2">
                                                <a href="{{ route('todos.edit', $todo) }}" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                    </svg>
                                                </a>
                                                <form action="{{ route('todos.destroy', $todo) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" onclick="return confirm('{{ __('Are you sure you want to delete this todo?') }}')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $todos->links() }}
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('No todos in this category') }}</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('Get started by creating a new todo.') }}</p>
                        <div class="mt-6">
                            <x-ui.button href="{{ route('todos.create', ['category_id' => $category->id]) }}" variant="primary" icon="heroicon-o-plus">
                                {{ __('New Todo') }}
                            </x-ui.button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </x-ui.container>
</x-layout.app> 