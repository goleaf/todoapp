<x-layout.app>
    <x-ui.container>
        <div class="py-12">
            <h2 class="text-2xl font-bold mb-6">Admin Todos List</h2>
            
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        <a href="{{ route('admin.todos.create') }}" class="px-4 py-2 text-white bg-blue-500 rounded">Add New Todo</a>
                    </div>
                    
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($todos as $todo)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $todo->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $todo->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $todo->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $todo->completed ? 'Completed' : 'Pending' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $todo->created_at->format('Y-m-d') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('admin.todos.edit', $todo) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        <a href="{{ route('admin.todos.show', $todo) }}" class="ml-2 text-blue-600 hover:text-blue-900">View</a>
                                        
                                        <form method="POST" action="{{ route('admin.todos.destroy', $todo) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="ml-2 text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this todo?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <div class="mt-4">
                        {{ $todos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </x-ui.container>
</x-layout.app>
