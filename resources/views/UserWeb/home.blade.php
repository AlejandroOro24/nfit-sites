@extends('UserWeb.layout.app')

@section('content')
<div id="dashboard" class="dashboard">
    <!-- Page Header Component -->
    <div class="page-header grid">
        <div class="title col-9">
            <h1 class="page-heading">Dashboard</h1>
        </div>
        @if ($activePlanUser)
            <div class="plan-info">
                <h4>{{ $activePlanUser->plan->plan }}</h4>
                <p>
                    Termina el {{ $activePlanUser->finish_date->format('d/m/y') }}
                </p>
            </div>
        @endif
    </div>

    <div class="flex flex-row gap-5">
        @if($lastVideo && auth()->user()->canSeeThisVideo($lastVideo))
        <div class="w-1/3">
            <!-- Ultimo Video -->
            <div class="last-video-dashboard section">
                <div class="section-header">
                    <h3 class="section-heading">Último Video</h3>
                </div>
                <a href="{{route('user.videos.show', ['video'=> $lastVideo->id ])}}" class="card-last-video">
                    <div class="img" style="background-image: url('{!!$lastVideo->thumbnail_path!!}');">
                        <div class="tag">Clase</div>
                    </div>
                    <div class="data">
                        <h3 class="title">{{$lastVideo->title}}</h3>
                        <div class="date">
                            <p class="the-date">
                                <span class="icon-calendar-simple"></span>
                                Subida el
                                {{-- <span>{{ $lastVideo->release_at->formatLocalized('%d de %B de %Y') }}</span> --}}
                                <span>{{ strftime('%d de %B de %Y', $lastVideo->release_at->timestamp) }}</span>
                                {{-- <span>15 de mayo de 2020</span> --}}
                            </p>
                            @if($lastVideo->duration )
                            <p class="time">
                                <span class="icon-time"></span>
                                <span>{{$lastVideo->duration }}</span>
                            </p>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
        </div>
        @else
            <div class="w-1/3">
                <!-- Ultimo Video -->
                <div class="last-video-dashboard section">
                    <div class="section-header">
                        <h3 class="section-heading">Último Video</h3>
                    </div>
                    <div class="card-no-data">
                        <img src="/user/assets/icons/video-icon.svg" alt="Video">
                        <p>
                            No hay videos para mostrar
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <div class="w-1/3">
            <!-- Próximas Clases: maximo dos -->
            <clase-next :auth_timezone_difference="{{ App\Models\System\NfitTimeZone::hoursDifferenceSportCenterVsAuthUser() }}"
                        :suggestedClases='@json($next_clases)'>
            </clase-next>
            <!-- Plan actual -->
            {{-- <div class="actual-plan-dashboard section">
                <div class="section-header">
                    <h3 class="section-heading">Plan Actual</h3>
                </div>
                @if($activePlanUser)
                <div class="card-actual-plan">
                    <div class="header">
                        <h4 class="name">
                            {{$activePlanUser->plan->plan}}
                        </h4>
                    </div>
                    <div class="body">
                        <div class="data-item">
                            <p>Vencimiento</p>
                            <span>{{$activePlanUser->finish_date->format('d/m/y')}}</span>
                        </div>
                        <div class="data-item">
                            <p>Estado</p>
                            <span class="tag confirmed">Activo</span>
                        </div>
                    </div>
                </div>
                @else
                <div class="card-actual-plan">
                    - sin plan activo -
                </div>
                @endif
            </div> --}}
        </div>

        <div class="w-1/3">
            <!-- Rutinas de Hoy -->
            <div class="dashboard-today-routines section">
                <div class="section-header">
                    <h3 class="section-heading">Rutinas de hoy</h3>
                </div>
                <wod-today :wods ='@json($wod)'></wod-today>
            </div>
        </div>

    </div>

</div>
@endsection