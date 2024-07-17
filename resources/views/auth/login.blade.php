{{-- <x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login' , ['tenant' => $tenantName] ) }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centro deportivo - Acceso</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/publicWeb.css')}}">

    <style>
      .shadow-login-logo {
        --tw-shadow: 0px 1px 25px -8px rgba(1, 237, 181, 1);
        --tw-shadow-colored: 0px 1px 25px -8px var(--tw-shadow-color);
        box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
      }
      body{
        background-image: url({{asset('/img/background.jpg')}});
      }
                        
    </style>
</head>
<body>
    <div class="wrapper">
        <main class="w-full max-w-md">
            <header class="block w-full mb-8">
                <a href="/" class="rounded-full">
                    <img src="{{ App\Models\Parameter::value('box_image')}}" alt="Logo Centro deportivo" class="w-20 lg:w-32  mx-auto shadow-login-logo rounded-full">
                </a>
            </header>
            <div class="border border-[#01FFC2] rounded-lg  py-8 px-7 w-full">
                <div class="mx-auto max-w-sm">
                    <h2 class="font-bold text-xl tracking-tight text-center mb-7">Acceso</h2>
                    <form action="{{ route('login' , ['tenant' => $tenantName] ) }}" method="post" class="form" id="formLogin">
                      @csrf

                        <input type="email" placeholder="Correo" id="email" name="email" required class="input-form">
                          @error('email')
                            <span class="text-red-500 text-xs " id="password-error">
                              {{ $message }}
                            </span>
                          @enderror

                        <input type="password" placeholder="Contraseña" id="input-password" name="password" required class="input-form">
                          @error('password')
                            <span class="text-red-500 text-xs" id="password-error">
                              {{ $message }}
                            </span>
                          @enderror
                        <!-- <input type="button" value="Iniciar Sesión" class="input-button"> -->
                        <input type="button" value="Iniciar Sesión" class="input-button active" onclick="document.getElementById('formLogin').submit()">
                    </form>
                    <div class="text-center mt-4">
                        <a href="{{ route('password.request' , ['tenant' => $tenantName] ) }}" class="link">Olvidé mi clave</a>
                    </div>
                </div>
            </div>
            <footer class="footer">
                <p>Con la tecnología de</p>
                <a href="https://nfit.app">
                    <img src="{{asset('/img/nfit-logo.png')}}" alt="NFIT">
                </a>
            </footer>
        </main>
    </div>
    <script src="/app.js"></script>
</body>
</html>
