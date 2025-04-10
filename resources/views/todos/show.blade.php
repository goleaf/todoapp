@extends('layouts.app')

@section('header')
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold tracking-tight text-gray-900">Todo Details</h1>
        <div class="flex space-x-3">
            <a href="{{ route('todos.edit', $todo) }}" class="inline-flex items-center rounded-md bg-yellow-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-yellow-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-yellow-600">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M2.695 14.763l-1.262 3.154a.5.5 0 00.65.65l3.155-1.262a4 4 0 001.343-.885L17.5 5.5a2.121 2.121 0 00-3-3L3.58 13.42a4 4 0 00-.885 1.343z" />
                </svg>
                Edit
            </a>
            <a href="{{ route('todos.index') }}" class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                Back to Todos
            </a>
        </div>
    </div>
@endsection

@section('content')
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="overflow-hidden bg-white shadow sm:rounded-lg">
        <div class="px-4 py-6 sm:px-6">
            <h3 class="text-2xl font-semibold leading-7 text-gray-900">{{ $todo->title }}</h3>
        </div>
        
        <div class="border-t border-gray-100">
            <dl class="divide-y divide-gray-100">
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-900">Status</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium {{ $todo->status == 'completed' ? 'bg-green-100 text-green-800' : ($todo->status == 'in_progress' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                            {{ ucfirst(str_replace('_', ' ', $todo->status)) }}
                        </span>
                    </dd>
                </div>
                
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-900">Priority</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium {{ $todo->priority == 'high' ? 'bg-red-100 text-red-800' : ($todo->priority == 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') }}">
                            {{ ucfirst($todo->priority) }}
                        </span>
                    </dd>
                </div>
                
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-900">Category</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        {{ $todo->category ? $todo->category->name : 'None' }}
                    </dd>
                </div>
                
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-900">Due Date</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        {{ $todo->due_date ? $todo->due_date->format('Y-m-d') : 'No due date' }}
                    </dd>
                </div>
                
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-900">Created</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        {{ $todo->created_at->format('Y-m-d H:i') }}
                    </dd>
                </div>
                
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-900">Last Updated</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        {{ $todo->updated_at->format('Y-m-d H:i') }}
                    </dd>
                </div>
                
                @if($todo->description)
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-900">Description</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        <p class="whitespace-pre-line">{{ $todo->description }}</p>
                    </dd>
                </div>
                @endif
            </dl>
        </div>
        
        @if($todo->parent)
        <div class="px-4 py-6 sm:px-6 border-t border-gray-200">
            <h3 class="text-base font-semibold leading-7 text-gray-900 mb-4">Parent Todo</h3>
            <div class="rounded-md border border-gray-200 bg-gray-50 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium">{{ $todo->parent->title }}</p>
                        <p class="mt-1 text-sm text-gray-500">
                            <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium {{ $todo->parent->status == 'completed' ? 'bg-green-100 text-green-800' : ($todo->parent->status == 'in_progress' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst(str_replace('_', ' ', $todo->parent->status)) }}
                            </span>
                        </p>
                    </div>
                    <a href="{{ route('todos.show', $todo->parent) }}" class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                        View Parent
                    </a>
                </div>
            </div>
        </div>
        @endif
        
        <div class="px-4 py-6 sm:px-6 border-t border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-semibold leading-7 text-gray-900">Subtasks ({{ $todo->subtasks->count() }})</h3>
                <a href="{{ route('todos.create') }}?parent_id={{ $todo->id }}" class="inline-flex items-center rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                    </svg>
                    Add Subtask
                </a>
            </div>
            
            @if($todo->subtasks->count() > 0)
                <ul role="list" class="divide-y divide-gray-100 rounded-md border border-gray-200">
                    @foreach($todo->subtasks as $subtask)
                        <li class="flex items-center justify-between py-4 pl-4 pr-5 text-sm leading-6">
                            <div class="flex w-0 flex-1 items-center">
                                <div class="ml-4 flex min-w-0 flex-1 gap-2">
                                    <span class="truncate font-medium {{ $subtask->status == 'completed' ? 'line-through text-gray-500' : '' }}">{{ $subtask->title }}</span>
                                    <span class="flex-shrink-0 text-gray-400">
                                        <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium {{ $subtask->status == 'completed' ? 'bg-green-100 text-green-800' : ($subtask->status == 'in_progress' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                            {{ ucfirst(str_replace('_', ' ', $subtask->status)) }}
                                        </span>
                                        <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium {{ $subtask->priority == 'high' ? 'bg-red-100 text-red-800' : ($subtask->priority == 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') }} ml-1">
                                            {{ ucfirst($subtask->priority) }}
                                        </span>
                                        @if($subtask->due_date)
                                            <span class="text-xs text-gray-500 ml-2">Due: {{ $subtask->due_date->format('Y-m-d') }}</span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class="ml-4 flex-shrink-0 flex space-x-2">
                                <a href="{{ route('todos.show', $subtask) }}" class="font-medium text-primary-600 hover:text-primary-500">View</a>
                                <a href="{{ route('todos.edit', $subtask) }}" class="font-medium text-yellow-600 hover:text-yellow-500">Edit</a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="rounded-md bg-blue-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                No subtasks created yet.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        
        <div class="flex items-center justify-between px-4 py-4 sm:px-6 border-t border-gray-200">
            <form action="{{ route('todos.destroy', $todo) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this todo?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" />
                    </svg>
                    Delete Todo
                </button>
            </form>
            <a href="{{ route('todos.edit', $todo) }}" class="inline-flex items-center rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M2.695 14.763l-1.262 3.154a.5.5 0 00.65.65l3.155-1.262a4 4 0 001.343-.885L17.5 5.5a2.121 2.121 0 00-3-3L3.58 13.42a4 4 0 00-.885 1.343z" />
                </svg>
                Edit Todo
            </a>
        </div>
    </div>
</div>
@endsection 