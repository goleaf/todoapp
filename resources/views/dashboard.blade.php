<x-layout.app :title="__('dashboard.dashboard')">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-6">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('dashboard.dashboard') }}
            </h2>
            <div class="flex space-x-2">
                <x-ui.button 
                    href="{{ route('todos.index') }}" 
                    variant="secondary" 
                    icon="heroicon-o-clipboard-document-list"
                >
                    {{ __('common.todos') }}
                </x-ui.button>
                <x-ui.button 
                    href="{{ route('dashboard') }}?new=true" 
                    variant="primary" 
                    icon="heroicon-o-plus"
                >
                    {{ __('dashboard.new_todo') }}
                </x-ui.button>
            </div>
        </div>

        <!-- Statistics Overview -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <x-ui.card withBorder class="bg-blue-50 dark:bg-blue-900/20">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-500/10 text-blue-600 dark:text-blue-400 mr-4">
                        <x-ui.icon icon="heroicon-o-clipboard-document-list" class="h-6 w-6" />
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('dashboard.total_todos') }}</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white" id="total-todos-count">-</p>
                    </div>
                </div>
            </x-ui.card>
            
            <x-ui.card withBorder class="bg-green-50 dark:bg-green-900/20">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-500/10 text-green-600 dark:text-green-400 mr-4">
                        <x-ui.icon icon="heroicon-o-check-circle" class="h-6 w-6" />
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('dashboard.completed_todos') }}</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white" id="completed-todos-count">-</p>
                    </div>
                </div>
            </x-ui.card>
            
            <x-ui.card withBorder class="bg-yellow-50 dark:bg-yellow-900/20">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-500/10 text-yellow-600 dark:text-yellow-400 mr-4">
                        <x-ui.icon icon="heroicon-o-clock" class="h-6 w-6" />
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('dashboard.pending_todos') }}</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white" id="pending-todos-count">-</p>
                    </div>
                </div>
            </x-ui.card>
        </div>

        <!-- New Todo Form - Only show when requested -->
        @if(request()->has('new'))
        <div class="mb-6">
            <x-ui.card withBorder>
                <form id="new-todo-form" method="POST" action="{{ route('api.todos.store') }}" class="space-y-6">
                    @csrf
                    <div class="space-y-4">
                        <x-input.form.group :label="__('dashboard.title')" for="title" :error="$errors->first('title')">
                            <x-input.input 
                                type="text" 
                                name="title" 
                                id="title" 
                                required 
                                autofocus 
                                :invalid="$errors->has('title')" 
                            />
                        </x-input.form.group>

                        <x-input.form.group 
                            :label="__('dashboard.description')" 
                            for="description" 
                            :error="$errors->first('description')"
                        >
                            <x-input.textarea
                                id="description"
                                name="description"
                                :invalid="$errors->has('description')"
                            />
                        </x-input.form.group>
                        
                        <x-input.form.group 
                            :label="__('dashboard.category')" 
                            for="category_id" 
                            :error="$errors->first('category_id')"
                        >
                            <x-input.select
                                id="category_id"
                                name="category_id"
                                :invalid="$errors->has('category_id')"
                            >
                                <option value="">{{ __('dashboard.select_category') }}</option>
                                @foreach(Auth::user()->categories()->get() as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </x-input.select>
                        </x-input.form.group>
                    </div>

                    <div class="flex items-center justify-end gap-x-4">
                        <x-ui.button 
                            href="{{ route('dashboard') }}" 
                            variant="secondary"
                        >
                            {{ __('dashboard.cancel') }}
                        </x-ui.button>
                        <x-ui.button 
                            type="submit" 
                            variant="primary" 
                            icon="heroicon-o-check-circle"
                        >
                            {{ __('dashboard.create_todo') }}
                        </x-ui.button>
                    </div>
                </form>
            </x-ui.card>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Recent Todos -->
            <div class="lg:col-span-2">
                <x-ui.card>
                    <x-slot name="header">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">
                                {{ __('dashboard.recent_todos') }}
                            </h3>
                            <x-ui.button 
                                href="{{ route('todos.index') }}" 
                                variant="link"
                                size="sm"
                            >
                                {{ __('dashboard.view_all') }}
                            </x-ui.button>
                        </div>
                    </x-slot>
                    
                    <div id="todo-list" class="divide-y divide-gray-200 dark:divide-gray-700">
                        <div class="py-10 text-center">
                            <x-ui.empty-state 
                                icon="heroicon-o-clipboard-document-list" 
                                title="{{ __('dashboard.no_todos_yet') }}" 
                                description="{{ __('dashboard.create_first_todo') }}" 
                            />
                        </div>
                    </div>
                </x-ui.card>
            </div>
            
            <!-- Categories Quick Access -->
            <div>
                <x-ui.card>
                    <x-slot name="header">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">
                                {{ __('dashboard.your_categories') }}
                            </h3>
                            <x-ui.button 
                                href="{{ route('categories.index') }}" 
                                variant="link"
                                size="sm"
                            >
                                {{ __('dashboard.view_all') }}
                            </x-ui.button>
                        </div>
                    </x-slot>
                    
                    <div id="categories-list" class="divide-y divide-gray-200 dark:divide-gray-700">
                        <div class="py-10 text-center">
                            <x-ui.empty-state 
                                icon="heroicon-o-tag" 
                                title="{{ __('dashboard.no_categories_yet') }}" 
                                description="{{ __('dashboard.create_first_category') }}" 
                            />
                        </div>
                    </div>
                    
                    <x-slot name="footer">
                        <x-ui.button 
                            href="{{ route('categories.create') }}" 
                            variant="outline"
                            class="w-full justify-center"
                            icon="heroicon-o-plus"
                        >
                            {{ __('dashboard.new_category') }}
                        </x-ui.button>
                    </x-slot>
                </x-ui.card>
            </div>
        </div>
    </div>

    <!-- JavaScript to handle todos and categories -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get CSRF token from meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Fetch and display todos and categories
            fetchTodos();
            fetchCategories();
            fetchStatistics();
            
            // Handle form submission
            const form = document.getElementById('new-todo-form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const formData = new FormData(form);
                    
                    fetch('{{ route("api.todos.store") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            title: formData.get('title'),
                            description: formData.get('description'),
                            category_id: formData.get('category_id') || null
                        }),
                        credentials: 'same-origin'
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Redirect to dashboard to see the new todo
                        window.location.href = '{{ route("dashboard") }}';
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                });
            }
        });
        
        function fetchTodos() {
            fetch('{{ route("api.todos.index") }}?limit=5', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                const todoList = document.getElementById('todo-list');
                
                // Check if we have data in the right format (data.data for paginated resources)
                const todos = data.data || data;
                
                if (!todos || todos.length === 0) {
                    return; // Keep the empty state
                }
                
                // Clear the todo list
                todoList.innerHTML = '';
                
                // Add each todo to the list
                todos.forEach(todo => {
                    const todoItem = document.createElement('div');
                    todoItem.className = 'py-4 flex items-start justify-between';
                    
                    // Define category badge HTML
                    const categoryBadge = todo.category ? 
                        `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-${todo.category.color}-100 text-${todo.category.color}-800 dark:bg-${todo.category.color}-800/20 dark:text-${todo.category.color}-400 mt-1 mr-2">
                            ${todo.category.name}
                        </span>` : '';
                    
                    todoItem.innerHTML = `
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center">
                                <input type="checkbox" id="todo-${todo.id}" class="toggle-todo mr-3 h-5 w-5 rounded border-gray-300 dark:border-gray-700 text-indigo-600 dark:text-indigo-500" 
                                    ${todo.status === 'completed' ? 'checked' : ''} data-id="${todo.id}">
                                <h4 class="text-lg font-medium ${todo.status === 'completed' ? 'line-through text-gray-500 dark:text-gray-400' : 'text-gray-900 dark:text-gray-100'}">${todo.title}</h4>
                            </div>
                            <div class="flex items-center mt-1">
                                ${categoryBadge}
                                <p class="text-sm text-gray-600 dark:text-gray-400">${todo.description || ''}</p>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <a href="#" onclick="window.location.href='{{ url('/todos') }}/' + todo.id + '/edit'; return false;" class="text-indigo-600 dark:text-indigo-500 hover:text-indigo-900 dark:hover:text-indigo-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                            </a>
                            <button class="delete-todo text-red-600 dark:text-red-500 hover:text-red-900 dark:hover:text-red-400" data-id="${todo.id}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    `;
                    todoList.appendChild(todoItem);
                });
                
                // Add event listeners for the toggle and delete buttons
                setupTodoEventListeners();
            })
            .catch(error => {
                console.error('Error fetching todos:', error);
            });
        }
        
        function fetchCategories() {
            fetch('{{ route("categories.api.index") }}', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                const categoriesList = document.getElementById('categories-list');
                
                // Check if we have data in the right format
                const categories = data.data || data;
                
                if (!categories || categories.length === 0) {
                    return; // Keep the empty state
                }
                
                // Clear the categories list
                categoriesList.innerHTML = '';
                
                // Add each category to the list (limited to 5)
                const displayCategories = categories.slice(0, 5);
                displayCategories.forEach(category => {
                    const categoryItem = document.createElement('div');
                    categoryItem.className = 'py-4 flex items-center justify-between';
                    categoryItem.innerHTML = `
                        <div class="flex items-center">
                            <span class="w-3 h-3 rounded-full mr-3" style="background-color: ${category.color};"></span>
                            <span class="text-gray-900 dark:text-gray-100">${category.name}</span>
                        </div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            ${category.todos_count} ${category.todos_count === 1 ? '{{ __("dashboard.todo") }}' : '{{ __("dashboard.todos") }}'}
                        </div>
                    `;
                    categoriesList.appendChild(categoryItem);
                });
            })
            .catch(error => {
                console.error('Error fetching categories:', error);
            });
        }
        
        function fetchStatistics() {
            fetch('{{ route("api.todos.statistics") }}', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('total-todos-count').textContent = data.total || 0;
                document.getElementById('completed-todos-count').textContent = data.completed || 0;
                document.getElementById('pending-todos-count').textContent = data.pending || 0;
            })
            .catch(error => {
                console.error('Error fetching statistics:', error);
            });
        }
        
        function setupTodoEventListeners() {
            // Add event listeners for the toggle checkboxes
            document.querySelectorAll('.toggle-todo').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const todoId = this.dataset.id;
                    const status = this.checked ? 'completed' : 'not_started';
                    
                    fetch(`{{ url('todos') }}/${todoId}/status`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({ status }),
                        credentials: 'same-origin'
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Update the UI to reflect the new status
                        const todoTitle = this.closest('.flex').querySelector('h4');
                        if (status === 'completed') {
                            todoTitle.classList.add('line-through', 'text-gray-500', 'dark:text-gray-400');
                        } else {
                            todoTitle.classList.remove('line-through', 'text-gray-500', 'dark:text-gray-400');
                        }
                        
                        // Refresh statistics
                        fetchStatistics();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                });
            });
            
            // Add event listeners for delete buttons
            document.querySelectorAll('.delete-todo').forEach(button => {
                button.addEventListener('click', function() {
                    if (!confirm('{{ __('dashboard.delete_confirmation') }}')) {
                        return;
                    }
                    
                    const todoId = this.dataset.id;
                    
                    fetch(`/api/todos/${todoId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        credentials: 'same-origin'
                    })
                    .then(response => {
                        if (response.ok) {
                            // Remove the todo from the UI
                            this.closest('.py-4').remove();
                            
                            // If no todos left, show the empty state
                            if (document.querySelectorAll('#todo-list .py-4').length === 0) {
                                document.getElementById('todo-list').innerHTML = `
                                    <div class="py-10 text-center">
                                        <x-ui.empty-state 
                                            icon="heroicon-o-clipboard-document-list" 
                                            title="{{ __('dashboard.no_todos_yet') }}" 
                                            description="{{ __('dashboard.create_first_todo') }}" 
                                        />
                                    </div>
                                `;
                            }
                            
                            // Refresh statistics
                            fetchStatistics();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                });
            });
        }
    </script>
</x-layout.app>
