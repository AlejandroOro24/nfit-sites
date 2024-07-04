<template>
    <div id="clases" class="clases">
        <!-- Page Header Component -->
        <!-- <div class="page-header grid">
            <div class="title col-18 col-6-m">
                <h1 class="page-heading">Clases</h1>
            </div>
            <clase-reserve></clase-reserve>
        </div> -->

        <!-- Page Header Component with reserve button -->
        <clase-reserve :auth_timezone_difference="auth_timezone_difference"></clase-reserve>

        <section class="section next-classes" >
            <div class="section-header">
                <h3 class="section-heading">Próximas Clases</h3>
            </div>
            <div class="card" v-if="loadings.areLoadedNext">
                <div class="responsive-table">
                    <table>
                        <thead>
                            <tr>
                                <th scope="col">Fecha</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Hora</th>
                                <th scope="col">Coach</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="clase of getNextClases" :key="clase.id">
                            <td>{{ formatedDate(clase.date) }}</td>
                                <td class="bold">{{ clase.clase_type }}</td>
                                <td>{{ zonedHour(clase.start_at) }}</td>
                                <td>{{ clase.first_name ? `${clase.first_name} ${clase.last_name}` : 'Sin coach'}}</td>
                                <td class="tag " :class="reservation_statuses[clase.reservation_status_id].class">
                                    {{ reservation_statuses[clase.reservation_status_id].status }}
                                </td>
                                <td>
                                    <button class="btn primary small"
                                            :class="{ disabled: clase.reservation_status_id != ReservationStatus.PENDIENTE }"
                                            :disabled="clase.reservation_status_id != ReservationStatus.PENDIENTE"
                                            v-on:click="claseConfirmOpen(clase)"
                                    >
                                        Confirmar
                                    </button>
                                    <a class="btn small" :href="`/u/clases/${clase.clase_id}`">Ver</a>
                                    <button class="btn caution small"
                                            :class="{ disabled: clase.reservation_status_id != ReservationStatus.PENDIENTE }"
                                            :disabled="clase.reservation_status_id != ReservationStatus.PENDIENTE"
                                            @click="claseDismissOpen(clase)"
                                    >
                                        Ceder
                                    </button>
                                    <a class="btn caution small"
                                        v-if="zoomLinkIsVisible(clase)"
                                        :href="clase.zoom_link"
                                        target="_blank"
                                    >
                                        Ir a Videollamada
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <button class="full table-load"
                        v-if="getNextClasesPagination.nextPage"
                        @click="loadNext(getNextClasesPagination.nextPage)"
                >Cargar más</button>
            </div>
            <div class="card" v-else>
                Sin proximas clases que mostrar...
            </div>
        </section>

        <section class="section prev-classes">
            <div class="section-header">
                <h3 class="section-heading">Clases Anteriores</h3>
            </div>
            <div class="card" v-if="loadings.areLoadedPast">
                <div class="responsive-table">
                    <table>
                        <thead>
                            <tr>
                                <th scope="col">Fecha</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Hora</th>
                                <th scope="col">Coach</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="clase of getPastClases" :key="clase.id">
                                <td>{{ formatedDate(clase.date) }}</td>
                                <td class="bold">{{ clase.clase_type }}</td>
                                <td>{{ zonedHour(clase.start_at) }}</td>
                                <td>{{ clase.first_name ? `${clase.first_name} ${clase.last_name}` : 'Sin coach'}}</td>
                                <td class="tag " :class="reservation_statuses[clase.reservation_status_id].class">
                                    {{ reservation_statuses[clase.reservation_status_id].status }}
                                </td>
                                <td><a class="btn small" :href="`/u/clases/${clase.clase_id}`">Ver</a></td>
                                <!-- <td>{{ data.clase.start_at }} hrs.</td>
                                <td>{{ data.clase.coach ? data.clase.coach.full_name : 'Sin coach' }}</td>
                                <td class="tag " :class="data.restatus.class" >{{ data.restatus.name }}</td>
                                <td>
                                    <a class="btn small" :href="data.clase.url">Ver</a>
                                </td> -->
                            </tr>
                        </tbody>
                    </table>
                </div>
                <button class="full table-load"
                        v-if="getPastClasesPagination.nextPage"
                        @click="loadPast(getPastClasesPagination.nextPage)"
                >Cargar más</button>
            </div>
            <div class="card" v-else>
                Sin datos que mostrar...
            </div>
        </section>
        <!-- // Modals -->
        <transition name="fade">
            <div class="modal" v-show="confirmShow" >
                <div class="modal-content center-modal" v-on:click.self="claseConfirmClose()">
                    <div class="modal-alert">
                        <!-- <img src=""> -->
                        <button class="close-modal" @click="claseConfirmClose()"></button>
                        <h2 class="modal-heading">Confirmar Asistencia</h2>
                        <p class="text-alert">
                            Recuerda que al confirmar tu asistencia no podrás ceder tu cupo y se contará como clase consumida.
                        </p>
                        <div class="buttons-modal">
                            <button class="primary" v-on:click="confirm()">Confirmar</button>
                        </div>
                        <p class="text-alert" v-if="alert.error">{{ alert.error }}</p>
                    </div>
                </div>
            </div>
        </transition>
        <transition name="fade">
            <div class="modal" v-show="dismissShow">
                <div class="modal-content center-modal" v-on:click.self="claseDismissClose()">
                    <div class="modal-alert">
                        <!-- <img src=""> -->
                        <button class="close-modal" @click="claseDismissClose()"></button>
                        <h2 class="modal-heading" >Ceder cupo</h2>
                        <p class="text-alert">
                            Con esto confirmas que no asistirás a esta clase y podrás reservar otra en otro horario durante este día.
                        </p>

                        <div class="buttons-modal">
                            <button class="caution" v-on:click="dismiss()">Ceder</button>
                        </div>
                        <p class="text-alert" v-if="alert.error">
                            {{alert.error}}
                        </p>
                    </div>
                </div>
            </div>
        </transition>

        <!-- <transition name="slide" >
            <div class="modal" v-show="reserveShow" v-on:click.self="claseReserveClose()" >
                <clase-reserve></clase-reserve>
            </div>
        </transition> -->
    </div>

</template>

<script>
    import axios from 'axios';
    import { mapGetters, mapActions, mapMutations } from 'vuex';
    import ReservationStatus from '../../constants/reservations-statuses.js';
    import moment from 'moment';
    export default {
        props: ['reservation_statuses', 'auth_timezone_difference'],
        data() {
            return {
                loadings : { areLoadedPast: false, areLoadedNext: false },
                reserveShow: false,
                confirmShow: false,
                dismissShow: false,
                selectedClase: [],
                alert: [],
                ReservationStatus
            }
        },
        mounted() {
            this.fetchPastClases().then(() => this.loadings.areLoadedPast = true);

            this.fetchNextClases().then(() => this.loadings.areLoadedNext = true);

            // console.log(moment().format());
        },
        computed: {
            ...mapGetters(['nextClases', 'pastClases', 'getNextClases', 'getPastClases', 'getPastClasesPagination', 'getNextClasesPagination']),
        },
        methods:{
            ...mapMutations({ loadNext: 'loadNextClases', loadPast: 'loadPastClases' }),
            ...mapActions(['fetchClases', 'sendAlert', 'fetchNextClases', 'fetchPastClases', 'resetNextClases']),
            // metodo para confirmar la reserva
            confirm() {
                axios.get('/clases/'+ this.selectedClase.clase_id  + '/confirm')
                .then(
                    response => {
                        this.resetNextClases();
                        this.claseConfirmClose()
                        this.sendAlert({
                            message: 'Clase confirmada con exito!',
                            class: 'success'
                        })
                    }
                )
                .catch(
                    error => {
                        console.log(error)
                        this.alert = error.response.data
                    }
                );
            },
            // metodo para ceder la reserva
            dismiss() {
                    axios.get('/clases/'+ this.selectedClase.clase_id + '/dismiss')
                    .then(
                        response => {
                            this.resetNextClases();
                            this.claseDismissClose()
                            this.sendAlert({
                                message: 'Clase cedida con exito!',
                                class: 'success'
                            })
                        }
                    )
                    .catch(
                        error => {
                            console.log(error)
                            this.alert = error.response.data
                        }
                    );
            },
            // modals
            claseConfirmOpen(clase) {
                // console.log(clase)
                this.selectedClase = clase
                this.confirmShow = true
            },
            claseConfirmClose() {
                this.selectedClase = []
                this.alert = []
                this.confirmShow = false
            },
            claseDismissOpen(clase) {
                this.selectedClase = clase
                this.alert = []
                this.dismissShow = true
            },
            claseDismissClose() {
                this.selectedClase = []
                this.dismissShow = false
            },
            claseReserveOpen() {
                this.reserveShow = true
            },
            claseReserveClose() {
                this.reserveShow = false
            },
            /**  Hard code date, splitting by dash, and reverse  */
            formatedDate(date) {
                return moment(date).format('DD/MM/Y');
            },
            /**
             *  Adjust an hour by auth user timezone
             */
            zonedHour(time) {
                if (this.auth_timezone_difference >= 0) {
                    return moment(time, 'HH:mm:ss').add(this.auth_timezone_difference, 'hours')
                                                    .format('HH:mm') + ' hrs.';
                }

                return moment(time, 'HH:mm:ss').subtract(this.auth_timezone_difference * -1, 'hours')
                                                .format('HH:mm') + ' hrs.';
            },
            zoomLinkIsVisible(clase) {
                // console.log(clase);
                if (!clase.zoom_link) {
                    return false;
                }
                let start_time = this.timeZonehourAndMinutes(clase.start_at);
                let finish_time = this.timeZonehourAndMinutes(clase.finish_at);

                let date = new Date;
                let now = this.hourAndMinutes(("0" + date.getHours()).slice(-2) +
                                ':' + ("0" + date.getMinutes()).slice(-2) +
                                ':' + ("0" + date.getSeconds()).slice(-2));

                let tenMinutesLater = new Date( Date.now() + 10000 * 60 ); // add 10 minutes to now
                let now_add_10 = this.hourAndMinutes(("0" + tenMinutesLater.getHours()).slice(-2) +
                                 ':' + ("0" + tenMinutesLater.getMinutes()).slice(-2) +
                                 ':' + ("0" + tenMinutesLater.getSeconds()).slice(-2));

                // console.log(now_add_10, start_time, now, finish_time);
                if (now_add_10 >= start_time && now <= finish_time) {
                    return true;
                }
                return false;
            },
            timeZonehourAndMinutes(time) {
                // console.log(time);
                let hour = parseInt(time.slice(0, -6));
                let minutes = parseInt(time.slice(3, -3));

                let date = new Date();
                date.setHours(hour, 0, 0);
                hour = date.getHours();

                hour = hour < 10 ? `0${hour}` : hour;
                minutes = minutes < 10 ? `0${minutes}` : minutes;

                return `${hour}:${minutes}`;
            },
            hourAndMinutes(time) {
                let hour = parseInt(time.slice(0, -6));
                let minutes = parseInt(time.slice(3, -3));

                return `${hour > 9 ? hour : '0' + hour}:${minutes > 9 ? minutes : '0' + minutes}`;
            }
        }

    }
</script>

<style scoped>
    .fade-enter-active, .fade-leave-active {
        transition: opacity 0.5s;
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0 !important;
    }

    .slide-enter-active .right-modal {
        animation: to-left 0.5s forwards;
    }
    .slide-leave-active .right-modal {
        animation: to-right 0.5s forwards;
    }
</style>

