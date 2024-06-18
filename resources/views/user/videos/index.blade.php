@extends('user.layouts.app')

@section('content')
<div id="videos" class="videos">
    <div class="page-header grid">
        <div class="title col-9">
            <h1 class="page-heading">Videos</h1>
        </div>
    </div>

    <!-- Page Categories -->
    <div class="page-categories">
        <a class="category active" href="/videos/">
            VOD
        </a>
        {{-- <a class="category" href="/videos/en-vivo.html">
            En Vivo
        </a> --}}
    </div>


    <video-grid></video-grid>
    {{-- <div class="video-grid">

        <!-- Video Item -->
        <a href="video.html" class="video-item">
            <div class="img" style="background-image: url('/assets/image/example-plan-cover.jpg');">
                <div class="tag">Clase</div>
            </div>
            <div class="data">
                <h3 class="title">Sparta Online: CrossFit Viernes 15 de Mayo</h3>
                <div class="date">
                    <p class="the-date">
                        <span class="icon-calendar-simple"></span>
                        Subida el <span>15 de Mayo de 2020</span>
                    </p>
                    <p class="time">
                        <span class="icon-time"></span>
                        <span>51</span> min
                    </p>
                </div>
            </div>
        </a>

        <!-- Video Item -->
        <a href="video.html" class="video-item">
            <div class="img" style="background-image: url('/assets/image/example-plan-cover.jpg');">
                <div class="tag">Clase</div>
            </div>
            <div class="data">
                <h3 class="title">Sparta Online: CrossFit Viernes 15 de Mayo</h3>
                <div class="date">
                    <p class="the-date">
                        <span class="icon-calendar-simple"></span>
                        Subida el <span>15 de Mayo de 2020</span>
                    </p>
                    <p class="time">
                        <span class="icon-time"></span>
                        <span>51</span> min
                    </p>
                </div>
            </div>
        </a>

        <!-- Video Item -->
        <a href="video.html" class="video-item">
            <div class="img" style="background-image: url('/assets/image/example-plan-cover.jpg');">
                <div class="tag">Clase</div>
            </div>
            <div class="data">
                <h3 class="title">Sparta Online: CrossFit Viernes 15 de Mayo</h3>
                <div class="date">
                    <p class="the-date">
                        <span class="icon-calendar-simple"></span>
                        Subida el <span>15 de Mayo de 2020</span>
                    </p>
                    <p class="time">
                        <span class="icon-time"></span>
                        <span>51</span> min
                    </p>
                </div>
            </div>
        </a>

        <!-- Video Item -->
        <a href="video.html" class="video-item">
            <div class="img" style="background-image: url('/assets/image/example-plan-cover.jpg');">
                <div class="tag">Clase</div>
            </div>
            <div class="data">
                <h3 class="title">Sparta Online: CrossFit Viernes 15 de Mayo</h3>
                <div class="date">
                    <p class="the-date">
                        <span class="icon-calendar-simple"></span>
                        Subida el <span>15 de Mayo de 2020</span>
                    </p>
                    <p class="time">
                        <span class="icon-time"></span>
                        <span>51</span> min
                    </p>
                </div>
            </div>
        </a>

        <!-- Video Item -->
        <a href="video.html" class="video-item">
            <div class="img" style="background-image: url('/assets/image/example-plan-cover.jpg');">
                <div class="tag">Clase</div>
            </div>
            <div class="data">
                <h3 class="title">Sparta Online: CrossFit Viernes 15 de Mayo</h3>
                <div class="date">
                    <p class="the-date">
                        <span class="icon-calendar-simple"></span>
                        Subida el <span>15 de Mayo de 2020</span>
                    </p>
                    <p class="time">
                        <span class="icon-time"></span>
                        <span>51</span> min
                    </p>
                </div>
            </div>
        </a>

        <!-- Video Item -->
        <a href="video.html" class="video-item">
            <div class="img" style="background-image: url('/assets/image/example-plan-cover.jpg');">
                <div class="tag">Clase</div>
            </div>
            <div class="data">
                <h3 class="title">Sparta Online: CrossFit Viernes 15 de Mayo</h3>
                <div class="date">
                    <p class="the-date">
                        <span class="icon-calendar-simple"></span>
                        Subida el <span>15 de Mayo de 2020</span>
                    </p>
                    <p class="time">
                        <span class="icon-time"></span>
                        <span>51</span> min
                    </p>
                </div>
            </div>
        </a>

    </div> --}}
</div>
@endsection
