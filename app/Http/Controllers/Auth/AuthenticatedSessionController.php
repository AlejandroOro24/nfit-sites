<?php

namespace App\Http\Controllers\Auth;

use App\Tools\Database\DataManager;
use App\Models\User;
use App\Models\Client;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;
use App\Tools\Database\DatabaseMan;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create($subdomain)
    {
        $tenantName = $subdomain;
        return view('auth.login' , compact('tenantName'));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request , $subdomain)
    {
        $client = Client::find(1);
        $tenant = $subdomain;
        $database = DataManager::initClientDB($client);
        
        $conection = $database->getConnection();
        // $user = $database::table('users')->where('email', $request->email)->first();
        $user = (new User)->setConnection($conection)->where('email', $request->email)->first();
        
        if ($user && Hash::check($request->password, $user->password)) {
            
            // dd($user);
            
            Auth::login($user);

            $request->session()->regenerate();
          
            return redirect()->intended(route('dashboard', ['tenant' => $tenant]));

        }else{
            RateLimiter::hit($this->throttleKey($request));
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);}
    }

    protected function throttleKey(Request $request)
    {
    return strtolower($request->input('email')) . '|' . $request->ip();
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
