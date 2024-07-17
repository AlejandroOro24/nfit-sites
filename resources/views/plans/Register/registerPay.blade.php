<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centro deportivo - Comprar un plan</title>
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
                    <img src="{{$sport_center->box_image}}" alt="Logo Centro deportivo" class="w-20 lg:w-24 mx-auto shadow-login-logo rounded-full">
                </a>
            </header>
            <div class="border border-[#01FFC2] rounded-lg py-8 lg:py-12 px-7 lg:px-12 tracking-tight">
                <div>
                    <h2 class="font-bold text-xl lg:text-2xl tracking-tight text-left mb-6 lg:mb-8">Compra tu plan</h2>
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-7">
                        <!-- Membership card -->
                        <div class="lg:order-3 lg:col-start-3 lg:col-end-4">
                            <div class="bg-black py-5 px-6 rounded-xl">
                                <header class="border-b pb-4 border-mid-black">
                                    <h4 class="font-bold text-base mb-2">{{$getplan->plan}}</h4>
                                    <p class="text-white/80 leading-normal text-[13px]">{{$getplan->description}}</p>
                                </header>
                                <div class="grid gap-1 pt-4">
                                    <div class="flex gap-1.5 text-white/70 text-[14px]">
                                        <img src="/img/icon-check.svg" alt="Check icon">
                                        <span>{{$getplan->class_numbers}} Clases</span>
                                    </div>
                                    <div class="flex gap-1.5 text-white/70 text-[14px]">
                                        <img src="/img/icon-check.svg" alt="Check icon">
                                        <span>Horario libre elección</span>
                                    </div>
                                    <div class="flex gap-1.5 text-white/70 text-[14px]">
                                        <img src="/img/icon-check.svg" alt="Check icon">
                                        <span>Reserva a través de la app</span>
                                    </div>
                                    <div class="flex gap-1.5 text-white/70 text-[14px]">
                                        <img src="/img/icon-check.svg" alt="Check icon">
                                        <span>Paga tu plan en linea</span>
                                    </div>
                                </div>
                                <div class="pt-5">
                                    <p class="font-bold text-[22px]">$<span>{{number_format($getplan->amount, 0, ',', '.')}}</span><span class="text-[11px] font-normal text-white/70">/mes</span></p>
                                </div>
                            </div>
                        </div>
                        <!-- Stepper and form -->
                        <div class="stepper lg:order-1 lg:col-start-1 lg:col-end-4">
                            <p>Paso 1: Accede</p>
                            <p class="active">Paso 2: Pago</p>
                        </div>
                        <div class="lg:order-2 lg:col-start-1 lg:col-end-3">
                            <p class="text-[12px] lg:text-sm !leading-relaxed mb-5 text-white/80">Serás redirigido a la pasarela de pago. Una vez que tu pago se haya procesado con éxito, podrás empezar a hacer reservas.</p>
                            <button class="button active lg:w-auto" onclick="window.open('/buy-plan/with-register/ready-step.html', '_self')">Ir a pagar →</button>
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