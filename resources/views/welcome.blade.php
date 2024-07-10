<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])


</head>
<body>
    {{-- <header class="header fixed top-0 z-30 transition duration-300 w-full" id="section-header"
    >
    <div class="x-5 md:px-10 lg:px-12 xl:px-16 1.5xl:px-[6vw] 2xl:px-0 2xl:mx-auto 2xl:max-w-7xl 3xl:max-w-8xl 4xl:max-w-9xl pt-6 md:py-6 w-full md:flex md:items-center md:justify-between">
        <div class="flex justify-between items-center gap-5 md:gap-8 pb-6 md:pb-0">
            <a href="/" className="flex items-center gap-2">
                <img src={logo} alt="Logo" className="w-6 h-6 rounded-full" />
                <h2 className="font-bold text-lg tracking-tight">{{$sport_center->box_name}}</h2>
              </a>
        </div>
    </div>
    </header> --}}

    <div id="app_3" class="m-auto">
        <public-header :sport_center='@json($sport_center)' ></public-header>
        <public-hero :sport_center='@json($sport_center)' ></public-hero>
        <public-disciplines :disciplines='@json($clases_types)' :sport_center='@json($sport_center)' ></public-disciplines>
        <public-reservations :sport_center='@json($sport_center)' :clases='@json($clase)' :clase_type='@json($clases_types)' ></public-reservations>
        <public-plans :memberships='@json($plans)' ></public-plans>
        <public-amenities></public-amenities>
        <public-contact :contact='@json($sport_center)'></public-contact>
        <public-mobile-app></public-mobile-app>
        <public-footer :sport_center='@json($sport_center)' ></public-footer>
    </div>
</body>
</html>