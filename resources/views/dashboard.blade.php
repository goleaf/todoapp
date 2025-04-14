<x-layout.app :title="__('dashboard.dashboard')">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-6">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('dashboard.my_todos') }}
            </h2>
            <x-ui.button 
                href="{{ route('dashboard') }}?new=true" 
                variant="primary" 
                icon="heroicon-o-plus"
            >
                {{ __('dashboard.new_todo') }}
            </x-ui.button>
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

        <!-- Todo List -->
        <div>
            <x-ui.card>
                <x-slot name="header">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">
                        {{ __('dashboard.your_todo_list') }}
                    </h3>
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
    </div>

    <!-- JavaScript to handle todos -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get CSRF token from meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Fetch and display todos
            fetchTodos();
            
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
                            description: formData.get('description')
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
            fetch('{{ route("api.todos.index") }}', {
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
                    todoItem.innerHTML = `
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center">
                                <input type="checkbox" id="todo-${todo.id}" class="toggle-todo mr-3 h-5 w-5 rounded border-gray-300 dark:border-gray-700 text-indigo-600 dark:text-indigo-500" 
                                    ${todo.status === 'completed' ? 'checked' : ''} data-id="${todo.id}">
                                <h4 class="text-lg font-medium ${todo.status === 'completed' ? 'line-through text-gray-500 dark:text-gray-400' : 'text-gray-900 dark:text-gray-100'}">${todo.title}</h4>
                            </div>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">${todo.description || ''}</p>
                        </div>
                        <div class="flex space-x-2">
                            <button class="edit-todo text-indigo-600 dark:text-indigo-500 hover:text-indigo-900 dark:hover:text-indigo-400" data-id="${todo.id}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                            </button>
                            <button class="delete-todo text-red-600 dark:text-red-500 hover:text-red-900 dark:hover:text-red-400" data-id="${todo.id}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    `;
                    todoList.appendChild(todoItem);
                });
                
                // Add event listeners for the toggle, edit, and delete buttons
                document.querySelectorAll('.toggle-todo').forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const todoId = this.dataset.id;
                        const status = this.checked ? 'completed' : 'pending';
                        
                        fetch(`/api/todos/${todoId}`, {
                            method: 'PUT',
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
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                    });
                });
                
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
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                    });
                });
                
                document.querySelectorAll('.edit-todo').forEach(button => {
                    button.addEventListener('click', function() {
                        const todoId = this.dataset.id;
                        window.location.href = `{{ route('dashboard') }}?edit=${todoId}`;
                    });
                });
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    </script>
</x-layout.app>
