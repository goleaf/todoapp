@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Admin - Edit Todo</h1>
        <form action="{{ route('admin.todos.update', $todo) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="user_id">User</label>
                <select name="user_id" id="user_id" class="form-control" required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $todo->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ $todo->title }}" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control">{{ $todo->description }}</textarea>
            </div>
            <div class="form-group">
                <label for="completed">Completed</label>
                <select name="completed" id="completed" class="form-control">
                    <option value="0" {{ $todo->completed == 0 ? 'selected' : '' }}>No</option>
                    <option value="1" {{ $todo->completed == 1 ? 'selected' : '' }}>Yes</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
