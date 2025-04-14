<?php

use App\Http\Controllers\Settings;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TodoController;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Help page - accessible to all users
Route::get('/help', function () {
    return view('help.index');
})->name('help');

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
        Route::get('/todos/{todo}', [AdminController::class, 'showTodo'])->name('todos.show');
        Route::get('/todos/{todo}/edit', [AdminController::class, 'editTodo'])->name('todos.edit');
        Route::put('/todos/{todo}', [AdminController::class, 'updateTodo'])->name('todos.update');
        Route::delete('/todos/{todo}', [AdminController::class, 'deleteTodo'])->name('todos.destroy');
    });
});

// Re-add API routes for testing
Route::prefix('api')->group(function () {
    Route::post('/register', [App\Http\Controllers\Api\AuthController::class, 'register']);
    Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);
        
        // Todo API routes
        Route::apiResource('/todos', TodoController::class)->names([
            'index' => 'api.todos.index',
            'store' => 'api.todos.store',
            'show' => 'api.todos.show',
            'update' => 'api.todos.update',
            'destroy' => 'api.todos.destroy',
        ]);
        
        // Category API routes
        Route::apiResource('/categories', \App\Http\Controllers\Api\CategoryController::class);
    });
});

require __DIR__.'/auth.php';
