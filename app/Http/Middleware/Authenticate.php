<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request )
    {
        // $subdomain = $request->route()->parameter('tenant');
        // dd($request->expectsJson());
        // return $request->expectsJson() ? null : route('login', ['tenant' => $subdomain]);
        $subdomain = $request->route('tenant');

        // Aquí puedes verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('login', ['tenant' => $subdomain]);
        }

        return $request;
    }

    }

