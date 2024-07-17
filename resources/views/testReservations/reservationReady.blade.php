<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centro deportivo - Reserva gratis</title>
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
        <main class="w-full max-w-lg lg:max-w-4xl">
            <header class="block w-full mb-8 lg:mb-10">
                <a href="/">
                    <img src="{{$sport_center->box_image}}" alt="Logo Centro deportivo" class="w-20 lg:w-32 mx-auto shadow-login-logo rounded-full">
                </a>
            </header>
            <div class="border border-[#01FFC2] rounded-lg py-8 lg:py-12 px-7 lg:px-12 tracking-tight">
                <div>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-12 lg:items-center">
                        <!-- Location -->
                        <div>
                            <div>
                                <h2 class="text-xl lg:text-3xl font-bold mb-2 lg:mb-4">¡Todo listo!</h2>
                                <p class="text-[12px] lg:text-sm !leading-relaxed text-white/80">
                                    Ya has reservado gratis en <span>{{$sport_center->box_name}}</span>.
                                    Te esperamos el <span>{{$trialClass->human_date}}</span> a las <span>{{$trialClass->start_at}}</span> hrs en <span>{{$sport_center->address}}</span>
                                </p>
                                <div class="flex flex-wrap gap-3 mt-5">
                                    <a href="https://www.google.com/maps?q={{ $sport_center->latitude }},{{ $sport_center->longitude }}" target="_blank" class="button active outline-button inline-button inline-flex items-center gap-1.5 px-5">
                                        <span>Mostrar en Google Maps →</span>
                                    </a>
                                    <a href="https://www.waze.com/ul?ll={{$sport_center->latitude}},{{$sport_center->longitude}}&navigate=yes" target="_blank" class="button active outline-button inline-button inline-flex items-center gap-1.5 px-5">
                                        <span>Mostrar en Waze →</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Download NFIT -->
                        <div>
                            <div class="mb-4 lg:mb-5">
                                <img src="{{asset('/img/nfit-logo.png')}}" alt="Logo NFIT" class="lg:w-20">
                            </div>
                            <div>
                                <h2 class="text-xl lg:text-3xl font-bold mb-2 lg:mb-4">
                                    En <span>Centro deportivo</span> usamos NFIT
                                </h2>
                                <p class="text-[12px] lg:text-sm !leading-relaxed text-white/80">
                                    <span>Centro deportivo</span> funciona con la tecnología de NFIT, con la app puedes reservar y confirmar tu asistencia, gestionar tu membresía entre otras funciones. Descarga la app:
                                </p>
                                <div class="flex flex-wrap gap-3 mt-5">
                                    <a href="https://apps.apple.com/us/app/nfit/id1458653773" target="_blank" class="button active inline-button inline-flex items-center gap-1.5 px-5">
                                        <img src="{{asset('/img/icon_apple.png')}}" alt="App Store icon">
                                        <span>App Store</span>
                                    </a>
                                    <a href="https://play.google.com/store/apps/details?id=com.asomic.nfit" target="_blank" class="button active inline-button inline-flex items-center gap-1.5 px-5">
                                        <img src="{{asset('/img/icon_google_play.png')}}" alt="Google Play icon">
                                        <span>Google Play</span>
                                    </a>
                                    <a href="{{route('home' , ['tenant' => $subdomain])}}" class="button active outline-button inline-button px-5 whitespace-nowrap">
                                        <span>No gracias, quiero ir a la versiñon web →</span>
                                    </a>
                                </div>
                            </div>
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