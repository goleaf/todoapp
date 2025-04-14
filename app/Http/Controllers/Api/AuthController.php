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
        try {
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
        } catch (\Exception $e) {
            return response()->json([
                'message' => __('messages.register_failed'),
                'error' => config('app.debug') ? $e->getMessage() : __('messages.server_error'),
            ], 500);
        }
    }
    
    /**
     * Login an existing user.
     */
    public function login(LoginRequest $request)
    {
        try {
            $validated = $request->validated();
            
            if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember_me'))) {
                return response()->json([
                    'message' => __('messages.invalid_credentials'),
                    'errors' => [
                        'email' => [__('messages.invalid_credentials')]
                    ]
                ], 401);
            }
            
            $user = User::where('email', $validated['email'])->firstOrFail();
            $token = $user->createToken('auth_token')->plainTextToken;
            
            // If using for a mobile app, you might want to invalidate previous tokens
            // Uncomment this if you want only one active token per user
            // $user->tokens()->where('id', '!=', $token->accessToken->id)->delete();
            
            return response()->json([
                'message' => __('messages.login_success'),
                'user' => new UserResource($user),
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => __('messages.login_failed'),
                'error' => config('app.debug') ? $e->getMessage() : __('messages.server_error'),
            ], 500);
        }
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
