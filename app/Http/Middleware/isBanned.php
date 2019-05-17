<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class isBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user() && Auth::user()->banned()) {
            $message = "Your account is banned.";
            auth()->logout();
            return redirect()->route('login')->withMessage($message);        
        }
        
        return $next($request);        
    }
}
