<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New Todo') }}
        </h2>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <form method="POST" action="{{ route('todos.store') }}">
                @csrf
                <div class="space-y-12">
                    <div class="border-b border-gray-900/10 dark:border-gray-700 pb-12">
                        <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-gray-100">{{ __('Todo Details') }}</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-400">{{ __('Fill in the details for your new task.') }}</p>

                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            {{-- Title --}}
                            <div class="sm:col-span-4">
                                <label for="title" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300">{{ __('Title') }}</label>
                                <div class="mt-2">
                                    <input type="text" name="title" id="title" value="{{ old('title') }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-300 dark:bg-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 @error('title') ring-red-500 dark:ring-red-500 @enderror" required autofocus>
                                </div>
                                @error('title')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Description --}}
                            <div class="col-span-full">
                                <label for="description" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300">{{ __('Description') }}</label>
                                <div class="mt-2">
                                    <textarea id="description" name="description" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-300 dark:bg-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 @error('description') ring-red-500 dark:ring-red-500 @enderror">{{ old('description') }}</textarea>
                                </div>
                                 @error('description')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                <p class="mt-3 text-sm leading-6 text-gray-600 dark:text-gray-400">{{ __('Write a few sentences about the task.') }}</p>
                            </div>

                            {{-- Category --}}
                             <div class="sm:col-span-3">
                                <label for="category_id" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300">{{ __('Category') }}</label>
                                <div class="mt-2">
                                    <select id="category_id" name="category_id" class="block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-300 dark:bg-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 @error('category_id') ring-red-500 dark:ring-red-500 @enderror">
                                        <option value="">{{ __('Select a category (optional)') }}</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('category_id')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                             {{-- Parent Todo --}}
                            <div class="sm:col-span-3">
                                <label for="parent_id" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300">{{ __('Parent Todo') }}</label>
                                <div class="mt-2">
                                    <select id="parent_id" name="parent_id" class="block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-300 dark:bg-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 @error('parent_id') ring-red-500 dark:ring-red-500 @enderror">
                                        <option value="">{{ __('None (Top-level todo)') }}</option>
                                        @foreach($parentTodos as $parentTodo)
                                            <option value="{{ $parentTodo->id }}" {{ old('parent_id') == $parentTodo->id ? 'selected' : '' }}>
                                                {{ $parentTodo->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('parent_id')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                             {{-- Due Date --}}
                            <div class="sm:col-span-2">
                                <label for="due_date" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300">{{ __('Due Date') }}</label>
                                <div class="mt-2">
                                    <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-300 dark:bg-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 @error('due_date') ring-red-500 dark:ring-red-500 @enderror">
                                </div>
                                 @error('due_date')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                             {{-- Priority --}}
                            <div class="sm:col-span-2">
                                <label for="priority" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300">{{ __('Priority') }}</label>
                                <div class="mt-2">
                                    <select id="priority" name="priority" class="block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-300 dark:bg-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 @error('priority') ring-red-500 dark:ring-red-500 @enderror" required>
                                         @foreach (App\Enums\TodoPriority::cases() as $priority)
                                            <option value="{{ $priority->value }}" {{ old('priority', App\Enums\TodoPriority::MEDIUM->value) == $priority->value ? 'selected' : '' }}>{{ $priority->label() }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('priority')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                             {{-- Status --}}
                            <div class="sm:col-span-2">
                                <label for="status" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300">{{ __('Status') }}</label>
                                <div class="mt-2">
                                    <select id="status" name="status" class="block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-300 dark:bg-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 @error('status') ring-red-500 dark:ring-red-500 @enderror">
                                         @foreach (App\Enums\TodoStatus::cases() as $status)
                                            <option value="{{ $status->value }}" {{ old('status', App\Enums\TodoStatus::PENDING->value) == $status->value ? 'selected' : '' }}>{{ $status->label() }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('status')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <a href="{{ route('todos.index') }}" class="text-sm font-semibold leading-6 text-gray-900 dark:text-gray-300">{{ __('Cancel') }}</a>
                    <button type="submit" class="rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-1.5 -ml-0.5 inline-block">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                        </svg>
                        {{ __('Create Todo') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout> 