@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Admin - Todos</h1>
        <a href="{{ route('admin.todos.create') }}" class="btn btn-primary">Create Todo</a>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Title</th>
                    <th>Completed</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($todos as $todo)
                    <tr>
                        <td>{{ $todo->id }}</td>
                        <td>{{ $todo->user->name }}</td>
                        <td>{{ $todo->title }}</td>
                        <td>{{ $todo->completed ? 'Yes' : 'No' }}</td>
                        <td>
                            <a href="{{ route('admin.todos.edit', $todo) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.todos.destroy', $todo) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
