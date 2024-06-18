<template>
    <div id="headbar" class="headbar mpd-xy">
        <div class="sport-center">
            <div class="avatar-center" :style="`background-image: url(${sport_center.box_image});`"></div>
            <h5>{{ sport_center.box_name }}</h5>
        </div>
        <div class="notifications">
                <!-- <div class="alerts">
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
            </div> -->
            <div class="profile-avatar">
                <div class="avatar-icon" :style="`background-image: url(${auth_user.avatar});`"></div>
                <div class="profile-wrapper">
                    <div class="profile-header">
                        <div class="img"></div>
                        <div class="data"></div>
                    </div>
                    <div class="profile-footer">
                        <a id="logout-link" href="#" @click.prevent="logout">
                            Cerrar Sesión
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Avisos -->
        <!-- <div class="special active caution">
            <span class="icon-icon-info"></span>
            <p class="message">
                Tu plan figura inpago, por favor regulariza tu pago para poder acceder todas las funciones.
            </p>
        </div>  -->
    </div>
</template>

<script>
    /**  For Promise http request  */
    import Axios from 'axios';

    export default {
        data() {
            return {
                sport_center: {},
                auth_user: {},
            }
        },
        mounted() {
            this.getAuthUserData();
            this.getBoxCenterData();
            // console.log(this.auth_user);
        },
        methods: {
            getBoxCenterData() {
                let tries = 0;
                Axios.get('/u/sport_center/data').then(response => {
                    // console.log(response.data.sport_center);
                    this.sport_center = response.data.sport_center;
                }).catch(error => {
                    if (tries < 2) {
                        setTimeout(() => {
                            // console.log('en getBoxCenterData en Header vez numero' + tries);
                            this.getBoxCenterData();
                            tries++;
                        }, 2000);
                    }
                });
            },
            getAuthUserData() {
                let tries = 0;
                Axios.get('/u/profile/show').then(response => {
                    // console.log(response.data.auth_user);
                    this.auth_user = response.data.auth_user;
                }).catch(error => {
                    if (tries < 2) {
                        setTimeout(() => {
                            // console.log('en getAuthUserData en Header vez numero' + tries);
                            this.getAuthUserData();
                            tries++;
                        }, 2000);
                    }
                });
            },
            logout() {
                if (confirm('¿Desea cerrar sesión?')) {
                    Axios.post('/logout')
                        .then(response => {
                            this.$router.push('/login');
                            location.reload();
                        }).catch(error => {
                            console.log(error);
                            location.reload();
                        });
                }
            }
        },
    }
</script>
