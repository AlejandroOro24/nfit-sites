<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>NFIT</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/user/css/app.css?v=2">
    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="{{ asset('/web/favicons/apple-touch-icon-57x57.png') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('/web/favicons/apple-touch-icon-114x114.png') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('/web/favicons/apple-touch-icon-72x72.png') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('/web/favicons/apple-touch-icon-144x144.png') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="60x60" href="{{ asset('/web/favicons/apple-touch-icon-60x60.png') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="{{ asset('/web/favicons/apple-touch-icon-120x120.png') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="76x76" href="{{ asset('/web/favicons/apple-touch-icon-76x76.png') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="{{ asset('/web/favicons/apple-touch-icon-152x152.png') }}" />
    <link rel="icon" type="image/png" href="{{ asset('/web/favicons/favicon-196x196.png') }}" sizes="196x196" />
    <link rel="icon" type="image/png" href="{{ asset('/web/favicons/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/png" href="{{ asset('/web/favicons/favicon-32x32.png') }}" sizes="32x32" />
    <link rel="icon" type="image/png" href="{{ asset('/web/favicons/favicon-16x16.png') }}" sizes="16x16" />
    <link rel="icon" type="image/png" href="{{ asset('/web/favicons/favicon-128.png') }}" sizes="128x128" />
    <meta name="application-name" content="NFIT WebApp"/>
    <meta name="msapplication-TileColor" content="#01FFC2" />
    <meta name="msapplication-TileImage" content="{{ asset('/web/favicons/mstile-144x144.png') }}" />
    <meta name="msapplication-square70x70logo" content="{{ asset('/web/favicons/mstile-70x70.png') }}" />
    <meta name="msapplication-square150x150logo" content="{{ asset('/web/favicons/mstile-150x150.png') }}" />
    <meta name="msapplication-wide310x150logo" content="{{ asset('/web/favicons/mstile-310x150.png') }}" />
    <meta name="msapplication-square310x310logo" content="{{ asset('/web/favicons/mstile-310x310.png') }}" />
</head>
<body>
    <div class="app" id="app">
        <!-- Toast -->
        <alert-toast></alert-toast>
        <!-- Navbar -->
        <sidebar-menu :auth_user="{{ Auth::user() }}"></sidebar-menu>
        <!-- Main -->
        {{-- For url segment /u/videos, if the segment 2 is videos, set dark eh background --}}
        <main @if(Request::segment(2) === 'videos') class="dark full-spacing" @endif>
            <!-- Headbar -->
            <header-bar></header-bar>
            {{-- @include('user.layouts.headbar') --}}
            <!-- Content -->
            @yield('content')
        </main>
        @yield('modal')
    </div>
    <script src="{{ asset('/js/app.js') }}"></script>
    <script src="/user/js/app.js?v=2"></script>
    @yield('script')
</body>
</html>