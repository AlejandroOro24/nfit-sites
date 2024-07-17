@extends('UserWeb.Layout.app')

@section('content')
<!-- Sección Single Video -->
<div id="clases" class="clases">
    <!-- Page Header Component -->
    <div class="page-header grid">
        <div class="title col-18 col-9-m">
            <div class="breadcrumb">
                <a href="{{ route('user.clases.index') }}">
                    < Clases
                </a>
            </div>
            <h1 class="page-heading">
                <img src="{{ $clase->claseType->icon }}">
                {{ $clase->claseType->clase_type }}
            </h1>
            <h3 class="page-subheading">
                <span>{{ $clase->human_date }}</span> · <span>{{ App\Models\System\Misc\NfitTimeZone::changeTimeAccordingAuthTimezone($clase->start_at) }} hrs</span>
                {{-- <span>Miércoles 15 de Julio de 2020</span> · <span>19:00 hrs</span> --}}
            </h3>
            @if ($clase->zoom_link &&
                    $clase->date_time_start <= now(auth()->user()->timezone)->addMinutes(10) &&
                    $clase->date_time_finish >= now(auth()->user()->timezone))
                <a target="_blank" href="{{ $clase->zoom_link }}" class="btn primary" style="margin-top: 8px;">Ir a Videollamada</a>
            @endif
        </div>
        {{-- botones de accion --}}
        <clase-action
            clase-id="{!!$clase->id!!}"
            {{-- has-reserve="{!!$clase->auth_has_reserve()!!}"
            can-reserve="{!!$clase->authCanReserveIt()!!}"
            status="{!!$clase->clase_status!!}" --}}
            >
        </clase-action>
        {{-- <p>{{$clase->auth_has_reserve()}}</p> --}}
        {{-- <div class="buttons col-18 col-9-m">
            <button class="primary">Entrar a Zoom</button>
            <button class="primary trigerModal-confirm">Confirmar</button>
            <button class="caution trigerModal-leave">Ceder Cupo</button>
        </div> --}}
    </div>

    <div class="grid">

        <div class="col-18 col-9-m col-5-xl">
            <section class="section next-classes">
                <div class="section-header">
                    <h3 class="section-heading">Rutina</h3>
                </div>
                    @if($clase->wod_id)
                        <div class="card">
                            @foreach ($clase->wod->stages as $stage)
                                <span class="title font-bold">
                                    {{ $stage->stage_type->stage_type }}
                                </span>
                                <p>
                                    {{ $stage->description}}
                                </p>
                            @endforeach
                        </div>
                    @else
                        <div class="card-no-data"><img src="/user/assets/icons/excercise-icon.svg" alt="Ejercicio"> <p>
                            No hay rutinas para mostrar
                        </p></div>
                    @endif
            </section>
        </div>

        <div class="col-18 col-9-m col-5-xl">
            {{-- componente de reservas --}}
            <clase-quota
                clase-id="{!!$clase->id!!}"
            ></clase-quota>

            @if($clase->coach)
            <section class="section next-classes" >
                <div class="section-header">
                    <h3 class="section-heading">Coach</h3>
                </div>
                <div class="card people-list">
                    <div class="item">
                        <div class="img" style="background-image: url({!! $clase->coach->avatar!!});"></div>
                        <div class="data">
                            <h4 class="name">{{$clase->coach->full_name}}</h4>
                        </div>
                    </div>
                </div>
            </section>
            @else
            <section class="section next-classes" >
                <div class="card people-list">
                    - Sin coach -
                </div>
            </section>
            @endif
        </div>

        <div class="col-18 col-8-xl">
            {{-- assistants --}}
            <clase-assistant
                clase-id="{!!$clase->id!!}"
            ></clase-assistant>
        </div>

    </div>
</div>

@endsection
