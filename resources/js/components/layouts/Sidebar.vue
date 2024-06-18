<template>
        <aside id="aside" :class="{'desktop-collapsed' : collapsed}">
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
                        <a href="/u">
                            <!-- <img src="assets/icons/dashboard.svg" alt="Dashboard"> -->
                            <span class="icon-dashboard"></span>
                            <span class="name">Dashboard</span>
                        </a>
                        <a href="/u/videos">
                            <!-- <img src="assets/icons/video.svg" alt="Videos"> -->
                            <span class="icon-video"></span>
                            <span class="name">Videos</span>
                        </a>
                        <a href="/u/clases">
                            <!-- <img src="assets/icons/calendar.svg" alt="Clases"> -->
                            <span class="icon-calendar"></span>
                            <span class="name">Clases</span>
                        </a>
                        <a href="/u/plans">
                            <!-- <img src="assets/icons/plan.svg" alt="Planes"> -->
                            <span class="icon-member"></span>
                            <span class="name">Planes</span>
                        </a>
                        <!-- <a href="" disabled>
                            <span class="icon-nutrition"></span>
                            <span class="name">Nutrición</span>
                        </a>
                        <a href="" disabled>
                            <span class="icon-market"></span>
                            <span class="name">Market</span>
                        </a> -->
                        <a href="/u/profile">
                            <!-- <img src="assets/icons/profile.svg" alt="Perfil"> -->
                            <span class="icon-profile"></span>
                            <span class="name">Perfil</span>
                        </a>
                    </ul>
                </nav>
                <div class="complementary">
                    <div class="desktop-collapse" id="desktopToggler" @click="changeCollapsed()">
                        <span class="icon-arrow" :class="{'collapsed' : collapsed}" ></span>
                    </div>
                    <!-- <nav-desktop-toggle></nav-desktop-toggle> -->
                    <div class="mobile-profile-avatar">
                        <div class="avatar">
                            <div class="image" :style="`background-image: url(${auth_user.avatar});`"></div>
                            <div class="data">
                                <h5>{{ upperCaseFirstLetter(auth_user.full_name) }}</h5>
                                <p>{{ upperCaseFirstLetter(roles[auth_user.role]) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="mobile-profile-avatar">
                        <div class="avatar">
                            <div class="data">
                                <a id="logout-link" href="#" @click.prevent="logout">
                                    <h5>Cerrar Sesión</h5>
                                </a>
                            </div>
                        </div>
                        </div>
                    <nav class="setting-menu">
                        <ul>
                            <!-- <a href="/u/settings"> -->
                            <a disabled>
                                <!-- <img src="assets/icons/settings.svg" alt="Ajustes"> -->
                                <span class="icon-settings"></span>
                                <span class="name">Ajustes</span>
                            </a>
                        </ul>
                    </nav>
                </div>
            </section>
        </aside>
</template>

<script>
    import axios from 'axios';

    export default {
        props: {
            auth_user: {}
        },
        data() {
            return {
                collapsed: false,
                roles: {}
            }
        },
        computed: {

        },
        created() {
            this.getRolesNames();
        },
        mounted() {
            let main = document.querySelector('main');

            if(localStorage.getItem('desktopNavCollapsed') == 'true') {
                this.collapsed = true;
                main.classList.add('full-spacing');
            }
            if(localStorage.getItem('desktopNavCollapsed') == 'false') {
                this.collapsed = false;
                main.classList.remove('full-spacing');
            }

        },
        methods:{
            changeCollapsed() {
                const main = document.querySelector('main');

                this.collapsed = ! this.collapsed
                localStorage.setItem('desktopNavCollapsed',this.collapsed)
                if(this.collapsed) {
                    main.classList.add('full-spacing');
                } else {
                    main.classList.remove('full-spacing');
                }
            },
            getRolesNames() {
                let tries = 0;
                axios.get('/u/roles').then(response => {
                    this.roles = response.data.roles;
                }).catch(error => {
                    if (tries < 2) {
                        setTimeout(() => {
                            // console.log('en getRolesNames en Header vez numero' + tries);
                            this.getRolesNames();
                            tries++;
                        }, 2000);
                    }
                });
            },
            /**  Convert to uppercase the first letter of every word  */
            upperCaseFirstLetter(value) {
                if (value) {
                    return value.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                        return letter.toUpperCase();
                    });
                }
            },
            logout() {
                if (confirm('¿Desea cerrar sesión?')) {
                    axios.post('/logout')
                        .then(response => {
                            this.$router.push('/login');
                            location.reload();
                        }).catch(error => {
                            console.log(error);
                            location.reload();
                        });
                }
            }
        }
    }
</script>
