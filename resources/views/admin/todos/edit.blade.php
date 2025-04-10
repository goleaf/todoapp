<x-app-layout>
    <x-slot name="header">
         <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Admin - Edit Todo') }}: {{ $todo->title }}
            </h2>
             <a href="{{ route('admin.todos.index') }}" class="inline-flex items-center rounded-md bg-white dark:bg-gray-700 px-3 py-2 text-sm font-semibold text-gray-900 dark:text-gray-200 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-1.5 -ml-0.5">
                    <path fill-rule="evenodd" d="M17 10a.75.75 0 0 1-.75.75H5.612l4.158 3.96a.75.75 0 1 1-1.04 1.08l-5.5-5.25a.75.75 0 0 1 0-1.08l5.5-5.25a.75.75 0 1 1 1.04 1.08L5.612 9.25H16.25A.75.75 0 0 1 17 10Z" clip-rule="evenodd" />
                </svg>
                {{ __('Back to Todos') }}
            </a>
        </div>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <form method="POST" action="{{ route('admin.todos.update', $todo) }}">
                @csrf
                @method('PUT')
                <div class="space-y-12">
                    <div class="border-b border-gray-900/10 dark:border-gray-700 pb-12">
                         <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-gray-100">{{ __('Todo Details') }}</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-400">{{ __('Update the details for this task.') }}</p>

                         <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            {{-- User --}}
                            <div class="sm:col-span-3">
                                <label for="user_id" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300">{{ __('User') }}</label>
                                <div class="mt-2">
                                    <select id="user_id" name="user_id" class="block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-300 dark:bg-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 @error('user_id') ring-red-500 dark:ring-red-500 @enderror" required>
                                        {{-- <option value="">{{ __('Select User') }}</option> --}}
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ old('user_id', $todo->user_id) == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('user_id')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                             {{-- Title --}}
                            <div class="sm:col-span-3">
                                <label for="title" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300">{{ __('Title') }}</label>
                                <div class="mt-2">
                                    <input type="text" name="title" id="title" value="{{ old('title', $todo->title) }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-300 dark:bg-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 @error('title') ring-red-500 dark:ring-red-500 @enderror" required>
                                </div>
                                @error('title')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Description --}}
                             <div class="col-span-full">
                                <label for="description" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300">{{ __('Description') }}</label>
                                <div class="mt-2">
                                    <textarea id="description" name="description" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-300 dark:bg-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 @error('description') ring-red-500 dark:ring-red-500 @enderror">{{ old('description', $todo->description) }}</textarea>
                                </div>
                                 @error('description')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                <p class="mt-3 text-sm leading-6 text-gray-600 dark:text-gray-400">{{ __('Write a few sentences about the task.') }}</p>
                            </div>

                             {{-- Category, Parent, Due Date, Priority, Status (copied from todos.edit) --}}
                            {{-- Add these fields here if they are relevant for admin editing --}}
                             {{-- Example: Status --}}
                             <div class="sm:col-span-2">
                                <label for="status" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300">{{ __('Status') }}</label>
                                <div class="mt-2">
                                    <select id="status" name="status" class="block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-300 dark:bg-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 @error('status') ring-red-500 dark:ring-red-500 @enderror">
                                         @foreach (App\Enums\TodoStatus::cases() as $status)
                                            {{-- Note: Comparing Enum object with old string value or existing Enum value --}}
                                            <option value="{{ $status->value }}" {{ old('status', $todo->status->value) == $status->value ? 'selected' : '' }}>{{ $status->label() }}</option>
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
                    <a href="{{ route('admin.todos.index') }}" class="text-sm font-semibold leading-6 text-gray-900 dark:text-gray-300">{{ __('Cancel') }}</a>
                    <button type="submit" class="rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">
                         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-1.5 -ml-0.5 inline-block">
                            <path d="M16.465 3.164a.75.75 0 0 0-1.03-1.09l-6.093 3.476-1.35-1.433a.75.75 0 0 0-1.097 1.028l2.103 2.224a.75.75 0 0 0 1.097-.027l6.373-6.678Z" />
                            <path d="M5.58 9.953a.75.75 0 0 0-1.03-1.09l-1.394.8L2.12 8.807a.75.75 0 0 0-1.097 1.028l1.26 1.335a.75.75 0 0 0 1.097-.028l2.19-2.289Z" />
                            <path fill-rule="evenodd" d="M11.84 1.291a11.99 11.99 0 0 0-9.075 4.164.75.75 0 0 0 .937 1.165A10.496 10.496 0 0 1 18.5 10.5c0 5.8-4.7 10.5-10.5 10.5S-2.5 16.3-2.5 10.5C-2.5 6.43 0 2.921 3.66 1.29a.75.75 0 1 0-.937-1.165A11.99 11.99 0 0 0 8 0c1.59 0 3.1.3 4.5 1.291a.75.75 0 1 0-.659.001Z" clip-rule="evenodd" />
                        </svg>
                        {{ __('Update Todo') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
