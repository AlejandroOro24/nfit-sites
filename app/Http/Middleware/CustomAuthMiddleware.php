<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Tools\Database\DataManager;

use Symfony\Component\HttpFoundation\Response;


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
        // dd($tenant);
        // DataManager::initClientDB(
        //     Client::where('sub_domain', $tenant)->first()
        // );
        // dd($next($request));
        // dd(Auth::user());

        if (!Auth::check()) {
            // dd(Auth::user());
            return redirect()->route('login' , ['tenant' => $tenant]);
        }
        return $next($request);
    }
}
