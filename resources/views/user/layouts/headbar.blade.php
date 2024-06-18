<div id="headbar" class="headbar mpd-xy">
    <div class="sport-center">
        <div class="avatar-center" style="background-image: url({!! \App\Models\Tenant\Settings\Parameter::value('box_image') ?? '' !!});"></div>
        <h5>{{ \App\Models\Tenant\Settings\Parameter::value('box_name') ?? '' }}</h5>
    </div>
    <div class="notifications">
        {{-- <div class="alerts">
            <span class="icon-notification"></span>
            <div class="notification-wrapper">
                <a class="item" href="">
                    <span class="icon-birthday"></span>
                    <div class="data">
                        ¡¡Feliz Cumpleaños!! Esperamos que tengas un gran día
                    </div>
                </a>
                <a class="item" href="/notificaciones/">
                    <span class="icon-message"></span>
                    <div class="data">
                        Has recibido un mensaje desde Sparta Sport Center
                    </div>
                </a>
                <a class="item" href="/planes/">
                    <span class="icon-member"></span>
                    <div class="data">
                        Tu plan está a punto de vencer! Renuévalo ahora.
                    </div>
                </a>
                <a class="item" href="/videos/video.html">
                    <span class="icon-video"></span>
                    <div class="data">
                        Se ha agregado un nuevo video. Haz click aquí para verlo
                    </div>
                </a>
                <a class="item" href="/clases/clase.html">
                    <span class="icon-calendar-simple"></span>
                    <div class="data">
                        Tienes una clase sin confirmar a las 19:00 hrs
                    </div>
                </a>
                <a href="/notificaciones" class="item-button">
                    <span class="icon-notification"></span> Ver Notificaciones
                </a>
            </div>
        </div> --}}
        <div class="profile-avatar">
            <div class="avatar-icon" style="background-image: url('{!!Auth::user()->avatar!!}');"></div>
            <div class="profile-wrapper">
                <div class="profile-header">
                    <div class="img"></div>
                    <div class="data"></div>
                </div>
                <div class="profile-footer">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('frm-logout').submit();">Logout</a>
                    <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Avisos -->
    {{-- <div class="special active caution">
        <span class="icon-icon-info"></span>
        <p class="message">
            Tu plan figura inpago, por favor regulariza tu pago para poder acceder todas las funciones.
        </p>
    </div> --}}
</div>
