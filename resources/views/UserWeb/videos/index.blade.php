@extends('UserWeb.layout.app')

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
</div>
@endsection
