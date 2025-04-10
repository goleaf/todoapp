<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/users', [AdminController::class, 'listUsers'])->name('admin.users.index');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.destroy');

    Route::get('/todos', [AdminController::class, 'listTodos'])->name('admin.todos.index');
    Route::get('/todos/create', [AdminController::class, 'createTodo'])->name('admin.todos.create');
    Route::post('/todos', [AdminController::class, 'storeTodo'])->name('admin.todos.store');
    Route::get('/todos/{todo}/edit', [AdminController::class, 'editTodo'])->name('admin.todos.edit');
    Route::put('/todos/{todo}', [AdminController::class, 'updateTodo'])->name('admin.todos.update');
    Route::delete('/todos/{todo}', [AdminController::class, 'deleteTodo'])->name('admin.todos.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('todos', TodoController::class);
});
