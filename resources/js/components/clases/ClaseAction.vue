<template>
    <div class="buttons col-18 col-9-m" v-if="clase.auth">
        <div v-if="clase.auth.has_reserve">
            <button class="primary" v-if="clase.zoom_active">Entrar a Zoom</button>
            <button class="primary" v-if="clase.auth.status_reserve.id == '1'" @click="claseConfirmOpen()">Confirmar</button>
            <button class="caution" v-if="clase.auth.status_reserve.id == '1'" @click="claseDismissOpen()">Ceder Cupo</button>
        </div>
        <div v-if="(clase.auth.can_reserve) && (!clase.auth.has_reserve)">
            <button class="primary" @click="reserve()">Reservar</button>
        </div>
        <transition name="fade">
            <div class="modal" v-show="confirmShow" >
                <div class="modal-content center-modal" v-on:click.self="claseConfirmClose()">
                    <div class="modal-alert">
                        <button class="close-modal" v-on:click="claseConfirmClose()"></button>
                        <!-- <img src=""> -->
                        <h2 class="modal-heading" >Confirmar Asistencia</h2>
                        <p class="text-alert">
                            Recuerda que al confirmar tu asistencia no podrás ceder tu cupo y se contará como clase consumida.
                        </p>
                        <div class="buttons-modal">
                            <button class="primary" v-on:click="confirm()">Confirmar</button>
                        </div>
                        <p class="text-alert" v-if="alert.error">
                            {{ alert.error }}
                        </p>
                    </div>
                </div>
            </div>
        </transition>

        <transition name="fade">
            <div class="modal" v-show="dismissShow">
                <div class="modal-content center-modal" v-on:click.self="claseDismissClose()">
                    <div class="modal-alert">
                        <button class="close-modal" v-on:click="claseDismissClose()"></button>
                        <!-- <img src=""> -->
                        <h2 class="modal-heading">Ceder cupo</h2>
                        <p class="text-alert">
                            Con esto confirmas que no asistirás a esta clase y podrás reservar otra en otro horario durante este día.
                        </p>

                        <div class="buttons-modal">
                            <button class="btn caution" v-on:click="dismiss()">Ceder</button>
                        </div>
                        <p class="text-alert" v-if="alert.error">
                            {{alert.error}}
                        </p>
                    </div>
                </div>
            </div>
        </transition>

        <transition name="fade">
            <div class="modal" v-if="alertModal">
                <div class="modal-content center-modal" v-on:click.self="alertClose()">
                    <div class="modal-alert">
                        <img src="">
                        <h2 class="modal-heading" >Alerta</h2>
                        <!-- <p class="text-alert">

                        </p> -->

                        <!-- <div class="buttons">
                            <button class="caution" v-on:click="dismiss()">Ceder</button>
                        </div> -->
                        <p class="text-alert" v-if="alertModal.error">
                            {{alertModal.error}}
                        </p>
                    </div>
                </div>
            </div>
        </transition>

    </div>

</template>

<script>
    import axios from 'axios'
    import { mapGetters, mapActions } from 'vuex'
    export default {
        props: {
            claseId: String,
            // hasReserve: String,
            // canReserve: String,
            // status: String,
        },
        data() {
            return {
                confirmShow: false,
                dismissShow: false,
                alert: [],
                alertModal: null,
                status: [],
            }
        },
        mounted() {
            this.fetchClase(this.claseId)
            console.log('hola entre!');
        },
        computed: {
            ...mapGetters(['clase'])
        },
        methods:{
            ...mapActions(['fetchClase','sendAlert']),
            reserve() {
                axios.post('/u/clases/'+ this.claseId + '/reserve').then(
                    response => {
                        // console.log(response);
                        this.fetchClase(this.claseId)
                        this.sendAlert({
                            message: 'clase reservada con exito!',
                            class: 'success'
                        })
                    }
                )
                .catch(error => {
                    this.alertModal = error.response.data
                });
            },
            confirm() {
                axios.get('/u/clases/'+ this.claseId  + '/confirm')
                .then(
                    response => {
                        this.fetchClase(this.claseId)
                        this.claseConfirmClose()
                        this.sendAlert({
                            message: 'clase confirmada con exito!',
                            class: 'success'
                        })
                    }
                )
                .catch(
                    error => {
                        // console.log(error.response.data)
                        this.alert = error.response.data
                    }
                );
            },
            // ceder cupo
            dismiss() {
                    axios.get('/u/clases/'+ this.claseId + '/dismiss')
                    .then(
                        response => {
                            // console.log(response)
                            this.fetchClase(this.claseId)
                            this.claseDismissClose()
                            this.sendAlert({
                                message: 'clase cedida con exito!',
                                class: 'success'
                            })
                        }
                    )
                    .catch(
                        error => {
                            // console.log(error.response.data)
                            this.alert = error.response.data
                        }
                    );
            },
            // reservar

            // modals
            claseConfirmOpen() {
                this.confirmShow = true
            },
            claseConfirmClose() {
                this.alert = []
                this.confirmShow = false
            },
            claseDismissOpen(clase) {
                this.alert = []
                this.dismissShow = true
            },
            claseDismissClose() {
                this.dismissShow = false
            },
            claseReserveOpen() {
                this.reserveShow = true
            },
            claseReserveClose() {
                this.reserveShow = false
            },
            alertClose() {
                this.alertModal = null
            },
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

</style>

