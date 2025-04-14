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
        $users = User::paginate(10);

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

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return redirect()->route('admin.users.index')->with('success', trans('admin.user_created'));
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => trans('admin.user_create_failed') . ' ' . $e->getMessage()]);
        }
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

        try {
            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            return redirect()->route('admin.users.index')->with('success', trans('admin.user_updated'));
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => trans('admin.user_update_failed') . ' ' . $e->getMessage()]);
        }
    }

    public function deleteUser(User $user)
    {
        // Prevent administrators from deleting their own account
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', trans('admin.cannot_delete_self'));
        }
        
        try {
            $user->delete();
            return redirect()->route('admin.users.index')->with('success', trans('admin.user_deleted'));
        } catch (\Exception $e) {
            return redirect()->route('admin.users.index')->with('error', trans('admin.user_delete_failed') . ' ' . $e->getMessage());
        }
    }

    public function listTodos()
    {
        $todos = Todo::paginate(10);

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

        try {
            Todo::create($request->all());
            return redirect()->route('admin.todos.index')->with('success', trans('admin.todo_created'));
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => trans('admin.todo_create_failed') . ' ' . $e->getMessage()]);
        }
    }

    public function showTodo(Todo $todo)
    {
        $users = User::all();

        return view('admin.todos.show', compact('todo', 'users'));
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

        try {
            $todo->update($request->all());
            return redirect()->route('admin.todos.index')->with('success', trans('admin.todo_updated'));
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => trans('admin.todo_update_failed') . ' ' . $e->getMessage()]);
        }
    }

    public function deleteTodo(Todo $todo)
    {
        try {
            $todo->delete();
            return redirect()->route('admin.todos.index')->with('success', trans('admin.todo_deleted'));
        } catch (\Exception $e) {
            return redirect()->route('admin.todos.index')->with('error', trans('admin.todo_delete_failed') . ' ' . $e->getMessage());
        }
    }
}
