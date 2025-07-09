<x-layout.app>
    <x-slot name="header">
         <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight truncate" title="{{ $todo->title }}">
                {{ __('Admin - Todo Details') }}: <span class="italic">{{ Str::limit($todo->title, 50) }}</span>
            </h2>
            <div class="flex items-center gap-x-3">
                <x-ui.button 
                    href="{{ route('admin.todos.edit', $todo) }}" 
                    variant="warning" 
                    size="sm" 
                    icon="heroicon-o-pencil-square"
                >
                    {{ __('Edit') }}
                </x-ui.button>
                <x-ui.button 
                    href="{{ route('admin.todos.index') }}" 
                    variant="secondary" 
                    size="sm" 
                    icon="heroicon-o-arrow-left"
                >
                    {{ __('Back to Todos') }}
                </x-ui.button>
            </div>
        </div>
    </x-slot>

    <x-ui.container>
        <div class="py-12">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Basic Information</h3>
                            <table class="min-w-full">
                                <tr>
                                    <td class="py-2 font-medium text-gray-700">ID:</td>
                                    <td>{{ $todo->id }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 font-medium text-gray-700">Title:</td>
                                    <td>{{ $todo->title }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 font-medium text-gray-700">User:</td>
                                    <td>{{ $todo->user->name }} ({{ $todo->user->email }})</td>
                                </tr>
                                <tr>
                                    <td class="py-2 font-medium text-gray-700">Status:</td>
                                    <td>
                                        <span class="px-2 py-1 text-xs font-medium rounded {{ $todo->completed ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ $todo->completed ? 'Completed' : 'Pending' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-2 font-medium text-gray-700">Created:</td>
                                    <td>{{ $todo->created_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 font-medium text-gray-700">Last Updated:</td>
                                    <td>{{ $todo->updated_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                            </table>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Description</h3>
                            <div class="p-4 bg-gray-50 rounded">
                                {{ $todo->description ?? 'No description provided' }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <form action="{{ route('admin.todos.destroy', $todo) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this todo?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Delete Todo</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-ui.container>
</x-layout.app> 