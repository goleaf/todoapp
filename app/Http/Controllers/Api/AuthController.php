<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Register a new user.
     */
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();
        
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
        
        $token = $user->createToken('auth_token')->plainTextToken;
        
        return response()->json([
            'message' => __('messages.register_success'),
            'user' => new UserResource($user),
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }
    
    /**
     * Login an existing user.
     */
    public function login(LoginRequest $request)
    {
        $validated = $request->validated();
        
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => __('messages.invalid_credentials'),
            ], 401);
        }
        
        $user = User::where('email', $validated['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        
        return response()->json([
            'message' => __('messages.login_success'),
            'user' => new UserResource($user),
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
    
    /**
     * Logout the current user.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        
        return response()->json([
            'message' => __('messages.logout_success'),
        ]);
    }
    
    /**
     * Get the authenticated user.
     */
    public function user(Request $request)
    {
        return new UserResource($request->user());
    }
}
