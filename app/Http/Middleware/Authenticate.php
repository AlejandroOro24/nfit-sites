<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Tools\Database\DataManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;


class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request, Closure $next )
    {
        // $subdomain = $request->route()->parameter('tenant');
        // dd($request->expectsJson());
        // return $request->expectsJson() ? null : route('login', ['tenant' => $subdomain]);
        $subdomain = $request->route('tenant');

        DataManager::initClientDB(
                    Client::where('sub_domain', $subdomain)->first()
                );
        // Aquí puedes verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('login', ['tenant' => $subdomain]);
        }

        return $next($request);
    }

    }

