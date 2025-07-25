<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and has admin role
        if (Auth::check() && Auth::user()->is_admin) {
            // Log admin access for audit trail
            Log::info('Admin access', ['user_id' => Auth::id(), 'path' => $request->path()]); // Reduced logging data
            
            return $next($request);
        }
        
        // Log unauthorized access attempt
        if (Auth::check()) {
            Log::warning('Unauthorized admin access attempt', ['user_id' => Auth::id(), 'path' => $request->path()]); // Reduced logging data
        } else {
            Log::warning('Unauthenticated admin access attempt', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'path' => $request->path(),
                'method' => $request->method(),
            ]);
        }
        
        // Redirect to home page with error message
        if ($request->expectsJson()) {
            return response()->json(['error' => trans('admin.access_denied')], 403);
        }
        
        return redirect()->route('home')->with('error', trans('admin.access_denied'));
    }
} 