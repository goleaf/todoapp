<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LoginRateLimiter
{
    /**
     * The rate limiter instance.
     *
     * @var \Illuminate\Cache\RateLimiter
     */
    protected $limiter;

    /**
     * Create a new login rate limiter middleware.
     *
     * @param  \Illuminate\Cache\RateLimiter  $limiter
     * @return void
     */
    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Use a combination of IP address and email for the key
        $key = $this->resolveRequestSignature($request);
        
        // Allow 5 login attempts in 1 minute
        $maxAttempts = 5;
        $decaySeconds = 60;

        if ($this->limiter->tooManyAttempts($key, $maxAttempts)) {
            $seconds = $this->limiter->availableIn($key);
            
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => trans('auth.throttle', [
                        'seconds' => $seconds,
                        'minutes' => ceil($seconds / 60),
                    ]),
                    'errors' => [
                        'email' => [trans('auth.throttle', [
                            'seconds' => $seconds,
                            'minutes' => ceil($seconds / 60),
                        ])]
                    ],
                    'retry_after' => $seconds
                ], 429);
            }
            
            return redirect()->back()->withInput($request->only('email', 'remember'))
                ->withErrors(['email' => trans('auth.throttle', [
                    'seconds' => $seconds,
                    'minutes' => ceil($seconds / 60),
                ])]);
        }

        // If the login attempt is unsuccessful, increment the rate limiter
        $response = $next($request);
        
        if ($response->getStatusCode() === 401 || 
            ($response->status() === 302 && session()->has('errors'))) {
            $this->limiter->hit($key, $decaySeconds);
        }

        return $response;
    }

    /**
     * Resolve request signature.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function resolveRequestSignature($request)
    {
        $email = $request->input('email') ?? '';
        return sha1($request->ip() . '|' . Str::lower($email) . '|login');
    }
} 