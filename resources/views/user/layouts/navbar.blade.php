
        <!-- Navbar -->
        <aside id="aside">
            <header>
                <a href="/" class="logo-link">
                    <img src="/user/assets/image/logo-full.png" class="logo-full" alt="Ir al Inicio">
                    <img src="/user/assets/image/logo.png" class="logo-collapsed" alt="Ir al Inicio">
                </a>
                <div class="toggler-mobile">
                    <a href="/notificaciones/" class="notification-link">
                        <img src="/user/assets/icons/notificaction.svg"><!-- ícono notifications -->
                    </a>
                    <a href="#" id="mobileToggler" class="menu-toggler-link">
                        <img src="/user/assets/icons/menu-toggler.svg"><!-- íconos menu -->
                    </a>
                </div>
            </header>
            <section class="menu" id="menu">
                <nav class="aside-menu">
                    <ul>
                        <a href="{{route('user.home')}}" @if(Request::segment(2) == null) class="active" @endif>
                            <!-- <img src="assets/icons/dashboard.svg" alt="Dashboard"> -->
                            <span class="icon-dashboard"></span>
                            <span class="name">Dashboard</span>
                        </a>
                        <a href="{{route('user.videos.index')}}" @if(Request::segment(2) == 'videos') class="active" @endif>
                            <!-- <img src="assets/icons/video.svg" alt="Videos"> -->
                            <span class="icon-video"></span>
                            <span class="name">Videos</span>
                        <a href="{{ route('user.clases.index')}}" @if(Request::segment(2) == 'clases') class="active" @endif>
                            <!-- <img src="assets/icons/calendar.svg" alt="Clases"> -->
                            <span class="icon-calendar"></span>
                            <span class="name">Clases</span>
                        </a>
                        <a href="{{ route('user.plans.index')}}" @if(Request::segment(2) == 'plans') class="active" @endif>
                            <!-- <img src="assets/icons/plan.svg" alt="Planes"> -->
                            <span class="icon-member"></span>
                            <span class="name">Planes</span>
                        </a>
                        <a href="" disabled>
                            <!-- <img src="assets/icons/nutrition.svg" alt="Nutrición"> -->
                            <span class="icon-nutrition"></span>
                            <span class="name">Nutrición</span>
                        </a>
                        <a href="" disabled>
                            <!-- <img src="assets/icons/market.svg" alt="Market"> -->
                            <span class="icon-market"></span>
                            <span class="name">Market</span>
                        </a>
                        <a href="" disabled>
                            <!-- <img src="assets/icons/profile.svg" alt="Perfil"> -->
                            <span class="icon-profile"></span>
                            <span class="name">Perfil</span>
                        </a>
                    </ul>
                </nav>
                <div class="complementary">
                    {{-- <div class="desktop-collapse" id="desktopToggler">
                        <span class="icon-arrow"></span><!-- Icon collapse -->
                    </div> --}}
                    <nav-desktop-toggle></nav-desktop-toggle>
                    <div class="mobile-profile-avatar">
                        <div class="avatar">
                            <div class="image" style="background-image: url('{{ Auth::user()->avatar }}');"></div>
                            <div class="data">
                                <h5>{{ Auth::user()->full_name }}</h5>
                                <p>{{ Auth::user()->role }}</p>
                            </div>
                        </div>
                    </div>
                    <nav class="setting-menu">
                        <ul>
                            <a href="#" disabled>
                                <!-- <img src="assets/icons/settings.svg" alt="Ajustes"> -->
                                <span class="icon-settings"></span>
                                <span class="name">Ajustes</span>
                            </a>
                        </ul>
                    </nav>
                </div>
            </section>
        </aside>

    