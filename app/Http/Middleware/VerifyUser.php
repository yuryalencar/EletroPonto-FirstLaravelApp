<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class VerifyUser
{
    /**
     * Handle an incoming request.
     * This Middleware verify if user is logged
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()){
            return $next($request);
        } else {
            return redirect()->route('login');
        }
    }
}
