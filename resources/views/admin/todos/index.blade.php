<x-layout.app>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Admin - Manage Todos') }}
            </h2>
            {{-- Optional: Add Create button if Admins can create todos --}}
            {{-- <a href="{{ route('admin.todos.create') }}" class="inline-flex items-center rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">
                 <x-ui.icon.heroicon-s-plus class="w-5 h-5 mr-1.5 -ml-0.5" />
                {{ __('Create New Todo') }}
            </a> --}}
        </div>
    </x-slot>

    {{-- Optional Filters (Similar to todos.index if needed) --}}
    {{-- @include('admin.todos.partials.filters') --}}

    {{-- Todo List Table --}}
    <div class="overflow-hidden bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
        @if($todos->count() > 0)
            <div class="overflow-x-auto">
                <x-data.table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 dark:text-gray-100 sm:pl-6">{{ __('ID') }}</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-100">{{ __('User') }}</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-100">{{ __('Title') }}</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-100">{{ __('Category') }}</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-100">{{ __('Status') }}</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-100">{{ __('Priority') }}</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-100">{{ __('Created') }}</th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                <span class="sr-only">{{ __('Actions') }}</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600 bg-white dark:bg-gray-800">
                        @foreach($todos as $todo)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 dark:text-gray-100 sm:pl-6">{{ $todo->id }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    {{-- Optional: Link to admin user view --}}
                                    {{ $todo->user->name }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $todo->title }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $todo->category?->name ?? __('None') }}</td>
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
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400" title="{{ $todo->created_at->translatedFormat('Y-m-d H:i:s') }}">
                                    {{ $todo->created_at->diffForHumans() }}
                                </td>
                                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                    <div class="flex space-x-3 justify-end">
                                         {{-- Assuming admin routes like admin.todos.show, admin.todos.edit, etc. exist --}}
                                        <x-ui.link href="{{ route('admin.todos.show', $todo) }}" class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-200">{{ __('View') }}</x-ui.link>
                                        <x-ui.link href="{{ route('admin.todos.edit', $todo) }}" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-200">{{ __('Edit') }}</x-ui.link>
                                        <form action="{{ route('admin.todos.destroy', $todo) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this todo?') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <x-ui.button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-200">{{ __('Delete') }}</x-ui.button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </x-data.table>
                <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                    <x-data.pagination :paginator="$todos" />
                </div>
            </div>
        @else
            {{-- Empty State --}}
             <div class="text-center px-4 py-12 sm:p-16">
                 {{-- <x-ui.icon.heroicon-o-clipboard-document-list class="mx-auto h-12 w-12 text-gray-400" /> --}}
                <h3 class="mt-2 text-sm font-semibold text-gray-900 dark:text-gray-100">{{ __('No todos found') }}</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('There are currently no todos in the system.') }}</p>
                 {{-- Optional: Add Create button if Admins can create todos --}}
                {{-- <div class="mt-6">
                    <a href="{{ route('admin.todos.create') }}" class="inline-flex items-center rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">
                         <x-ui.icon.heroicon-s-plus class="w-5 h-5 mr-1.5 -ml-0.5" />
                        {{ __('Create New Todo') }}
                    </a>
                </div> --}}
            </div>
        @endif
    </div>
</x-layout.app>
