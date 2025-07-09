<x-layout.app>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Categories') }}
            </h2>
            <x-ui.button href="{{ route('categories.create') }}" icon="heroicon-o-plus" variant="primary">
                {{ __('Create Category') }}
            </x-ui.button>
        </div>
    </x-slot>

    <x-ui.container>
        <div class="py-12">
            <x-feedback.action-message class="mb-4" :status="session('status')" />

            @if($categories->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($categories as $category)
                        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden hover:shadow-md transition-shadow">
                            <div class="p-5 border-l-4" style="border-color: {{ $category->color }}">
                                <div class="flex justify-between items-start">
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                                        <a href="{{ route('categories.show', $category) }}" class="hover:underline">
                                            {{ $category->name }}
                                        </a>
                                    </h3>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('categories.edit', $category) }}" class="text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300" onclick="return confirm('{{ __('Are you sure you want to delete this category?') }}')">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @if($category->description)
                                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                        {{ Str::limit($category->description, 100) }}
                                    </p>
                                @endif
                                <div class="mt-3 flex justify-between items-center">
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $category->todos_count }} 
                                        {{ trans_choice('todos', $category->todos_count) }}
                                    </span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ __('Created') }}: {{ $category->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <x-ui.empty-state 
                    icon="heroicon-o-tag" 
                    title="{{ __('No Categories Yet') }}" 
                    description="{{ __('Create categories to organize your todos and make them easier to manage.') }}"
                >
                    <x-ui.button href="{{ route('categories.create') }}" variant="primary" icon="heroicon-o-plus">
                        {{ __('Create Your First Category') }}
                    </x-ui.button>
                </x-ui.empty-state>
            @endif
        </div>
    </x-ui.container>
</x-layout.app> 