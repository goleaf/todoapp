<?php

use App\Http\Controllers\Settings;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TodoController;
use Illuminate\Http\Request;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
})->name('home');

// Help page - accessible to all users
Route::get('/help', function () {
    return view('help.index');
})->name('help');

// Language Switcher
Route::get('language/{locale}', [\App\Http\Controllers\LanguageController::class, 'switchLang'])->name('language.switch');

// Accessibility page - accessible to all users
Route::get('/accessibility', function () {
    return view('accessibility.index');
})->name('accessibility');

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
    Route::get('settings/accessibility', [Settings\AccessibilityController::class, 'edit'])->name('settings.accessibility.edit');
    Route::put('settings/accessibility', [Settings\AccessibilityController::class, 'update'])->name('settings.accessibility.update');
    Route::get('settings/language', [Settings\LanguageController::class, 'edit'])->name('settings.language.edit');
    Route::put('settings/language', [Settings\LanguageController::class, 'update'])->name('settings.language.update');
    
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
        
        // Translation Management
        Route::get('/translations', [\App\Http\Controllers\Admin\TranslationController::class, 'index'])->name('translations.index');
        Route::get('/translations/{locale}', [\App\Http\Controllers\Admin\TranslationController::class, 'show'])->name('translations.show');
        Route::put('/translations/{locale}/{file}', [\App\Http\Controllers\Admin\TranslationController::class, 'update'])->name('translations.update'); // Update file content
        Route::post('/translations', [\App\Http\Controllers\Admin\TranslationController::class, 'store'])->name('translations.store'); // Add new locale
        Route::delete('/translations/{locale}', [\App\Http\Controllers\Admin\TranslationController::class, 'destroy'])->name('translations.destroy'); // Delete locale
        Route::post('/translations/{locale}/file', [\App\Http\Controllers\Admin\TranslationController::class, 'storeFile'])->name('translations.file.store'); // Add new file to locale
        Route::delete('/translations/{locale}/{file}', [\App\Http\Controllers\Admin\TranslationController::class, 'destroyFile'])->name('translations.file.destroy'); // Delete file from locale
        Route::post('/translations/{locale}/import', [\App\Http\Controllers\Admin\TranslationController::class, 'import'])->name('translations.import'); // Import translations from base language
        Route::get('/translations/{locale}/{file}/{key}/edit', [\App\Http\Controllers\Admin\TranslationController::class, 'editKey'])->name('translations.key.edit'); // Edit a specific key
        Route::put('/translations/{locale}/{file}/{key}', [\App\Http\Controllers\Admin\TranslationController::class, 'updateKey'])->name('translations.key.update'); // Update a specific key
    });

    // Todo routes
    Route::get('/todos', [TodoController::class, 'index'])->name('todos.index');
    Route::get('/todos/create', [TodoController::class, 'create'])->name('todos.create');
    Route::post('/todos', [TodoController::class, 'store'])->name('todos.store');
    Route::get('/todos/{todo}', [TodoController::class, 'show'])->name('todos.show');
    Route::get('/todos/{todo}/edit', [TodoController::class, 'edit'])->name('todos.edit');
    Route::patch('/todos/{todo}', [TodoController::class, 'update'])->name('todos.update');
    Route::delete('/todos/{todo}', [TodoController::class, 'destroy'])->name('todos.destroy');
    
    // AJAX route for updating todo status
    Route::patch('/todos/{todo}/status', [TodoController::class, 'updateStatus'])->name('todos.update-status');
});

/**
 * Admin Translation Management Routes
 */
Route::middleware(['auth', 'admin'])->prefix('admin/translations')->name('admin.translations.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\TranslationController::class, 'index'])->name('index');
    Route::get('/create-language', [App\Http\Controllers\Admin\TranslationController::class, 'createLanguage'])->name('create-language');
    Route::post('/create-language', [App\Http\Controllers\Admin\TranslationController::class, 'storeLanguage'])->name('store-language');
    Route::delete('/languages/{locale}', [App\Http\Controllers\Admin\TranslationController::class, 'destroyLanguage'])->name('destroy-language');
    
    Route::get('/languages/{locale}', [App\Http\Controllers\Admin\TranslationController::class, 'language'])->name('language');
    Route::get('/languages/{locale}/create-file', [App\Http\Controllers\Admin\TranslationController::class, 'createFile'])->name('create-file');
    Route::post('/languages/{locale}/create-file', [App\Http\Controllers\Admin\TranslationController::class, 'storeFile'])->name('store-file');
    Route::delete('/languages/{locale}/files/{file}', [App\Http\Controllers\Admin\TranslationController::class, 'destroyFile'])->name('destroy-file');
    
    Route::get('/languages/{locale}/files/{file}', [App\Http\Controllers\Admin\TranslationController::class, 'edit'])->name('edit');
    Route::put('/languages/{locale}/files/{file}', [App\Http\Controllers\Admin\TranslationController::class, 'update'])->name('update');
    
    // New routes for scanning and importing
    Route::post('/scan', [App\Http\Controllers\Admin\TranslationController::class, 'scan'])->name('scan');
    Route::post('/languages/{locale}/import', [App\Http\Controllers\Admin\TranslationController::class, 'import'])->name('import');
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
