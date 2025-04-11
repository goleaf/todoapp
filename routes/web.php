<?php

use App\Http\Controllers\Settings;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', [Settings\ProfileController::class, 'edit'])->name('settings.profile.edit');
    Route::put('settings/profile', [Settings\ProfileController::class, 'update'])->name('settings.profile.update');
    Route::delete('settings/profile', [Settings\ProfileController::class, 'destroy'])->name('settings.profile.destroy');
    Route::get('settings/password', [Settings\PasswordController::class, 'edit'])->name('settings.password.edit');
    Route::put('settings/password', [Settings\PasswordController::class, 'update'])->name('settings.password.update');
    Route::get('settings/appearance', [Settings\AppearanceController::class, 'edit'])->name('settings.appearance.edit');
    
    // Admin Routes
    Route::prefix('admin')->name('admin.')->middleware(['admin'])->group(function () {
        // Users
        Route::get('/users', [AdminController::class, 'listUsers'])->name('users.index');
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.destroy');
        
        // Todos
        Route::get('/todos', [AdminController::class, 'listTodos'])->name('todos.index');
        Route::get('/todos/create', [AdminController::class, 'createTodo'])->name('todos.create');
        Route::post('/todos', [AdminController::class, 'storeTodo'])->name('todos.store');
        Route::get('/todos/{todo}', [AdminController::class, 'editTodo'])->name('todos.show');
        Route::get('/todos/{todo}/edit', [AdminController::class, 'editTodo'])->name('todos.edit');
        Route::put('/todos/{todo}', [AdminController::class, 'updateTodo'])->name('todos.update');
        Route::delete('/todos/{todo}', [AdminController::class, 'deleteTodo'])->name('todos.destroy');
    });
});

require __DIR__.'/auth.php';
