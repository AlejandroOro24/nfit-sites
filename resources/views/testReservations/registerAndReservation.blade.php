<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Centro deportivo - Reserva gratis</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
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
    {{-- {{dd($trialClass->id)}} --}}
    <div class="wrapper">
        <main class="w-full max-w-lg lg:max-w-4xl">
            <header class="block w-full mb-8 lg:mb-10">
                <a href="/">
                    <img src="{{$sport_center->box_image}}" alt="Logo Centro deportivo" class="w-20 lg:w-32 mx-auto shadow-login-logo rounded-full">
                </a>
            </header>
            <div class="border rounded py-8 lg:py-12 px-7 lg:px-12 tracking-tight ">
                <div>
                    <h2 class="font-bold text-xl lg:text-2xl tracking-tight text-left mb-6 lg:mb-8">Registrate en {{$sport_center->box_name}}</h2>
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-7">
                        <!-- Membership card -->
                        <div class="lg:order-3 lg:col-start-3 lg:col-end-4">
                            <div class="bg-black py-5 px-6 rounded-xl">
                                <header class="border-b pb-4 border-mid-black">
                                    <h4 class="font-bold text-base mb-2">Clase de prueba</h4>
                                    {{-- <p class="text-white/80 leading-normal text-[13px]">Jueves 26/04/24</p>
                                    <p class="text-white/80 leading-normal text-[13px]">10:00 AM</p> --}}
                                </header>
                                <div class="grid gap-1 pt-4">
                                    <div class="flex gap-1.5 text-white/70 text-[14px]">
                                        <img src="{{asset('/img/icon-check.svg')}}" alt="Check icon">
                                        <span> 1 Clase</span>
                                    </div>
                                    <div class="flex gap-1.5 text-white/70 text-[14px]">
                                        <img src="{{asset('/img/icon-check.svg')}}" alt="Check icon">
                                        <span> {{$trialClass->human_date}}</span>
                                    </div>
                                    <div class="flex gap-1.5 text-white/70 text-[14px]">
                                        <img src="{{asset('/img/icon-check.svg')}}" alt="Check icon">
                                        <span> {{$trialClass->start_at}}</span>
                                    </div>
                                    <div class="flex gap-1.5 text-white/70 text-[14px]">
                                        <img src="{{asset('/img/icon-check.svg')}}" alt="Check icon">
                                        <span> {{$sport_center->box_address}}</span>
                                    </div>
                                </div>
                                <div class="pt-5">
                                    <p class="font-bold text-[22px]">$<span>0</span></p>
                                </div>
                            </div>
                        </div>
                        <!-- Stepper and form -->
                        <div class="stepper lg:order-1 lg:col-start-1 lg:col-end-4">
                            <p class="active">Paso 1: Registro</p>
                            <p>Paso 2: Listo!</p>
                        </div>
                        <div class="lg:order-2 lg:col-start-1 lg:col-end-3">
                            <form action="{{route('registerTrial.store' , ['tenant' => $subdomain , 'clase' => $trialClass->id])}}" method="POST" class="form with-cols">
                                @csrf
                                <input type="text" placeholder="Nombre" name="first_name" class="input-form" required>
                                <input type="text" placeholder="Apellido" name="last_name" class="input-form" required>
                                <input type="email" placeholder="Correo" name="email" class="input-form" required>
                                <input type="text" placeholder="Teléfono" name="phone" class="input-form" required>
                                <input type="password" placeholder="Contraseña" name="password" class="input-form" required>
                                <input type="password" placeholder="Confirma tu Contraseña"  class="input-form">
                                <input type="submit" value="Regístrate" class="input-button active" >
                            </form>
                        </div>
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