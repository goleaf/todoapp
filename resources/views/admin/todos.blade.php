@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Admin - Todos</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Title</th>
                    <th>Completed</th>
                </tr>
            </thead>
            <tbody>
                @foreach($todos as $todo)
                    <tr>
                        <td>{{ $todo->id }}</td>
                        <td>{{ $todo->user->name }}</td>
                        <td>{{ $todo->title }}</td>
                        <td>{{ $todo->completed ? 'Yes' : 'No' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
