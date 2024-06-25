<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class CustomAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $tenant = $request->route()->parameter('tenant');
        
        // dd($next($request));
        // dd(Auth::user());

        if (!Auth::check()) {
            // dd(Auth::user());
            return redirect()->route('login' , ['tenant' => $tenant]);
        }
        return $next($request);
    }
}
