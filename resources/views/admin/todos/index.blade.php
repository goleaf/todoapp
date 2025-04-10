@extends('layouts.app')

@section('content')
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-100">
            {{ __('Todos') }}
        </h2>
        <x-ui.button href="{{ route('admin.todos.create') }}" variant="primary">
            {{ __('Create Todo') }}
        </x-ui.button>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(session('success'))
                        <x-feedback.alert type="success" :message="session('success')" />
                    @endif

                    <div class="overflow-x-auto">
                        <x-data.table>
                            <x-slot name="header">
                                <x-data.table.heading>{{ __('ID') }}</x-data.table.heading>
                                <x-data.table.heading>{{ __('User') }}</x-data.table.heading>
                                <x-data.table.heading>{{ __('Title') }}</x-data.table.heading>
                                <x-data.table.heading>{{ __('Category') }}</x-data.table.heading>
                                <x-data.table.heading>{{ __('Status') }}</x-data.table.heading>
                                <x-data.table.heading>{{ __('Priority') }}</x-data.table.heading>
                                <x-data.table.heading>{{ __('Created') }}</x-data.table.heading>
                                <x-data.table.heading class="relative">
                                    <span class="sr-only">{{ __('Actions') }}</span>
                                </x-data.table.heading>
                            </x-slot>
                            
                            @forelse($todos as $todo)
                                <x-data.table.row>
                                    <x-data.table.cell class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 dark:text-gray-100 sm:pl-0">
                                        {{ $todo->id }}
                                    </x-data.table.cell>
                                    <x-data.table.cell class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $todo->user->name }}
                                    </x-data.table.cell>
                                    <x-data.table.cell class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $todo->title }}
                                    </x-data.table.cell>
                                    <x-data.table.cell class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $todo->category?->name ?? '-' }}
                                    </x-data.table.cell>
                                    <x-data.table.cell class="whitespace-nowrap px-3 py-4 text-sm">
                                        <x-ui.status :status="$todo->status">
                                            {{ $todo->status }}
                                        </x-ui.status>
                                    </x-data.table.cell>
                                    <x-data.table.cell class="whitespace-nowrap px-3 py-4 text-sm">
                                        <x-ui.status :status="$todo->priority">
                                            {{ $todo->priority }}
                                        </x-ui.status>
                                    </x-data.table.cell>
                                    <x-data.table.cell class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $todo->created_at->format('M d, Y') }}
                                    </x-data.table.cell>
                                    <x-data.table.cell class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                        <x-ui.link href="{{ route('admin.todos.show', $todo) }}" class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-200">{{ __('View') }}</x-ui.link>
                                        <x-ui.link href="{{ route('admin.todos.edit', $todo) }}" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-200">{{ __('Edit') }}</x-ui.link>
                                        <form action="{{ route('admin.todos.destroy', $todo) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this todo?') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-200">{{ __('Delete') }}</button>
                                        </form>
                                    </x-data.table.cell>
                                </x-data.table.row>
                            @empty
                                <x-data.table.row>
                                    <x-data.table.cell colspan="8" class="px-3 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                        {{ __('No todos found.') }}
                                    </x-data.table.cell>
                                </x-data.table.row>
                            @endforelse
                        </x-data.table>
                    </div>

                    <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                        <x-data.pagination :paginator="$todos" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 