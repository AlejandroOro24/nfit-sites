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

    <div id="app_3" class="m-auto">
        <public-header :sport_center='@json($sport_center)'></public-header>
        <public-hero :sport_center='@json($sport_center)'></public-hero>
        <public-disciplines :disciplines='@json($clases_types)' :sport_center='@json($sport_center)'></public-disciplines>
        <public-reservations :sport_center='@json($sport_center)' :clases='@json($clase)' :clase_type='@json($clases_types)'></public-reservations>
        <public-plans :memberships='@json($plans)'></public-plans>
        <public-amenities></public-amenities>
        <public-contact :contact='@json($sport_center)'></public-contact>
        <public-mobile-app></public-mobile-app>
        <public-footer :sport_center='@json($sport_center)'></public-footer>
        <public-floating-whatsapp :sport_center='@json($sport_center)'></public-floating-whatsapp>
    </div>
    <script>
        window.routes = {
          registerBuy: "{{ route('registerAndBuy.index', ['id' => ':id', 'tenant' => ':otherData']) }}".replace(':otherData', '{{ $subdomain }}')
        };
      </script>
</body>
</html>