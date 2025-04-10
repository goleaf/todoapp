<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TodoController; // Import TodoController
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);

    // Todo API routes
    Route::apiResource('/todos', TodoController::class);
});
