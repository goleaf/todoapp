@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold tracking-tight text-gray-900">Edit Todo</h1>
@endsection

@section('content')
<div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
    <div class="overflow-hidden bg-white shadow sm:rounded-lg">
        <div class="d-flex justify-content-between align-items-center p-6">
            <span>{{ __('Edit Todo') }}</span>
            <div>
                <a href="{{ route('todos.show', $todo) }}" class="btn btn-sm btn-info me-2">View Details</a>
                <a href="{{ route('todos.index') }}" class="btn btn-sm btn-secondary">Back to Todos</a>
            </div>
        </div>

        <form method="POST" action="{{ route('todos.update', $todo) }}" class="p-6">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium leading-6 text-gray-900">Title</label>
                    <div class="mt-2">
                        <input type="text" name="title" id="title" value="{{ old('title', $todo->title) }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 @error('title') ring-red-500 @enderror" required autofocus>
                        @error('title')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium leading-6 text-gray-900">Description</label>
                    <div class="mt-2">
                        <textarea id="description" name="description" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 @error('description') ring-red-500 @enderror">{{ old('description', $todo->description) }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Category and Parent Todo -->
                <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2">
                    <div>
                        <label for="category_id" class="block text-sm font-medium leading-6 text-gray-900">Category</label>
                        <select id="category_id" name="category_id" class="mt-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 @error('category_id') ring-red-500 @enderror">
                            <option value="">Select a category (optional)</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $todo->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="parent_id" class="block text-sm font-medium leading-6 text-gray-900">Parent Todo</label>
                        <select id="parent_id" name="parent_id" class="mt-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 @error('parent_id') ring-red-500 @enderror">
                            <option value="">None (Top-level todo)</option>
                            @foreach($parentTodos as $parentTodo)
                                <option value="{{ $parentTodo->id }}" {{ old('parent_id', $todo->parent_id) == $parentTodo->id ? 'selected' : '' }}>
                                    {{ $parentTodo->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('parent_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Due Date and Priority -->
                <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2">
                    <div>
                        <label for="due_date" class="block text-sm font-medium leading-6 text-gray-900">Due Date</label>
                        <div class="mt-2">
                            <input type="date" name="due_date" id="due_date" value="{{ old('due_date', $todo->due_date ? $todo->due_date->format('Y-m-d') : '') }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 @error('due_date') ring-red-500 @enderror">
                            @error('due_date')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div>
                        <label for="priority" class="block text-sm font-medium leading-6 text-gray-900">Priority</label>
                        <select id="priority" name="priority" class="mt-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 @error('priority') ring-red-500 @enderror" required>
                            <option value="low" {{ old('priority', $todo->priority) == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ old('priority', $todo->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ old('priority', $todo->priority) == 'high' ? 'selected' : '' }}>High</option>
                        </select>
                        @error('priority')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium leading-6 text-gray-900">Status</label>
                    <select id="status" name="status" class="mt-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 @error('status') ring-red-500 @enderror">
                        <option value="pending" {{ old('status', $todo->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ old('status', $todo->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ old('status', $todo->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    @error('status')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <a href="{{ route('todos.index') }}" class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
                <button type="submit" class="rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">Update Todo</button>
            </div>
        </form>
    </div>
</div>
@endsection 