@extends('user.layouts.app')

@section('content')
<!-- Sección Single Video -->
            <div id="single-video-wrapper" class="single-video-wrapper grid">
                <div class="single-video col-18 col-13-xl">
                    <div class="single-video-header">
                        <div class="video-title">
                            <div class="back-link">
                                <a href="/u/videos/">
                                    < Videos
                                </a>
                            </div>
                            <span class="tag">Clase</span>
                            <h2 class="title">{{ $video['title'] }}</h2>
                        </div>
                        <div class="date-wrapper">
                            <p class="date">
                                <span class="icon-calendar-simple"></span>
                                Publicado el {{ strftime("%e %b %Y", strtotime($video['release_at'])) }}
                            </p>
                            <p class="time">
                                <span class="icon-time"></span>
                                <span>{{ $video['duration'] }}</span> 
                            </p>
                        </div>
                    </div>
                    <div class="single-video-frame">
                        <!-- aqui va el video -->
                        <iframe src="https://player.vimeo.com/video/{{ $video['id'] }}"
                            width="100%"
                            height="auto"
                            frameborder="0"
                            webkitallowfullscreen
                            mozallowfullscreen
                            allowfullscreen>
                        </iframe>

                    </div>
                </div>
                <div class="single-video-box col-18 col-5-xl">
                    <div class="header">
                        <a class="link-tab active" href="#">
                            Descripción
                        </a>
                        <a class="link-tab" href="#">
                            Comentarios
                        </a>
                    </div>
                    <div class="content">
                        <div class="tab-content box-rutina active" id="box-rutina">
                            <!-- Rutina -->
                            <div class="tab-content-body">
                                <div class="rutina">
                                    {!! $video['description'] !!}
                                </div>
                            </div>
                        </div>
                        
                        <!-- Comentarios -->
                        <video-comment v-bind:video-id="{!! $video['id'] !!}" :auth_user_id="{{ json_encode(Auth::id()) }}" ></video-comment>
                    </div>
                </div>
            </div>

@endsection