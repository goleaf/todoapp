<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;

class AdminController extends Controller
{
    public function listUsers()
    {
        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index')->with('success', Lang::get('messages.user_created'));
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('admin.users.index')->with('success', Lang::get('messages.user_updated'));
    }

    public function deleteUser(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', Lang::get('messages.user_deleted'));
    }

    public function listTodos()
    {
        $todos = Todo::all();

        return view('admin.todos.index', compact('todos'));
    }

    public function createTodo()
    {
        $users = User::all();

        return view('admin.todos.create', compact('users'));
    }

    public function storeTodo(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'completed' => 'nullable|boolean',
        ]);

        Todo::create($request->all());

        return redirect()->route('admin.todos.index')->with('success', Lang::get('messages.todo_created'));
    }

    public function editTodo(Todo $todo)
    {
        $users = User::all();

        return view('admin.todos.edit', compact('todo', 'users'));
    }

    public function updateTodo(Request $request, Todo $todo)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'completed' => 'nullable|boolean',
        ]);

        $todo->update($request->all());

        return redirect()->route('admin.todos.index')->with('success', Lang::get('messages.todo_updated'));
    }

    public function deleteTodo(Todo $todo)
    {
        $todo->delete();

        return redirect()->route('admin.todos.index')->with('success', Lang::get('messages.todo_deleted'));
    }
}
