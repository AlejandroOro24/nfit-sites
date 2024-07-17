<template>
<div>
        <div class="page-header grid">
            <div class="title col-18 col-6-m">
                <h1 class="page-heading">Clases</h1>
                <!-- <button class="primary" @click="modalShow = !modalShow">Reservar Clase</button> -->
            </div>
            <!-- <button class="primary" @click="modalShow = !modalShow">Reservar Clase</button> -->
            <div class="buttons col-18 col-12-m">
                <button class="px-2.5 py-2.5 mx-2 bg-nfit text-xs leading-3 font-bold hover:bg-nfit-light disabled:bg-nfit-disabled rounded" @click="modalShow = !modalShow">Reservar Clase</button>
            </div>
                <!-- <clase-reserve></clase-reserve>   -->
        </div>


        <transition name="slide">
            <div class="modal" v-if="modalShow" v-on:click.self="modalShow = !modalShow" >
                <div class="modal-content right-modal">
                    <div class="modal-header">
                        <div class="title">
                            <h2 class="modal-heading" >Reservar una Clase</h2>
                            <div class="close-modal-header" @click="modalShow = !modalShow">✕</div>
                            <!-- <p @click="modalShow = !modalShow">poto</p> -->
                        </div>
                    </div>
                    <div class="modal-body">
                        <div v-if="(reserveStage == 1) && (stageLoaded) ">
                            <!-- <span>Cerrar</span> -->
                            <h3 class="modal-section-heading">Selecciona una Clase</h3>

                            <div class="options classOptions">
                                <div class="option" v-for="type of types" :key="type.id" @click="selectType(type)">
                                    <img class="ml-3" v-bind:src="type.icon">
                                    <h5 class="class-name">{{ type.clase_type }}</h5>
                                </div>
                            </div>

                        </div>
                        <!-- <transition name="stageone"> -->
                        <div v-if="(reserveStage == 2) && (stageLoaded)">
                            <div class="right-modal-stage-one">
                                <a class="back-link" @click="stageSub()">≪ Volver</a>
                                <h3 class="modal-section-heading">
                                    Selecciona un Día   
                                </h3>
                                <div class="options dayOptions">
                                    <div class="option" v-for="day of week" :key="day.day" v-bind:class="{ disabled: !day.dayHasClases }" @click="selectDay(day)">
                                        <h5 class="day-name">{{day.dayName}}</h5>
                                        <h2 class="day-number">{{day.day}}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- </transition> -->


                        <div v-if="(reserveStage == 3) && (stageLoaded) ">
                            <a class="back-link" @click="stageSub()">≪ Volver</a>
                            <h3 class="modal-section-heading">
                                Selecciona una Hora
                            </h3>
                            <div class="options hourOptions" v-if="blocks.length > 0">
                                <div class="option-large" :class="clase.reservation_count >= clase.quota ? 'disabled' : ''" v-for="clase of blocks" :key="clase.id" @click="selectClase(clase)">
                                    <p class="day-hour">{{ zonedHour(clase.start_at) }}</p>
                                    <p class="hour-spaces" v-if="clase.reservation_count < clase.quota">Quedan <span>{{ clase.quota - clase.reservation_count }}</span> cupos</p>
                                    <p class="hour-spaces" v-else>Sin Cupos</p>
                                </div>
                            </div>
                            <div class="options hourOptions" v-else>
                                No hay horas disponibles para este día
                            </div>
                        </div>


                        <div v-if="(reserveStage == 4) && (stageLoaded)">
                            <a class="back-link" @click="stageSub()">≪ Volver</a>
                            <h3 class="modal-section-heading">Cupos</h3>
                            <div class="grid space-available">
                                <div class="col-9 item reserved">
                                    <span class="space-number">{{ 10 > clase.quorum ? `0${clase.quorum}` : clase.quorum }}</span>
                                    <h5 class="space-name">Reservados</h5>
                                </div>
                                <div class="col-9 item available">
                                    <span class="space-number">{{ (clase.quota - clase.quorum) &lt; 10 ?
                                                                    `0${clase.quota - clase.quorum}` :
                                                                    clase.quota - clase.quorum }}</span>
                                    <h5 class="space-name">Disponibles</h5>
                                </div>
                            </div>

                            <div class="modal-section">
                                <h3 class="modal-section-heading">Coach</h3>
                                <div class="card people-list" >
                                    <div class="item" v-if="clase.coach">
                                        <div class="img" :style="`background-image: url(${clase.coach.avatar});`"></div>
                                        <div class="data">
                                            <h4 class="name">{{ clase.coach.full_name }}</h4>
                                        </div>
                                    </div>
                                    <div class="item" v-else>
                                        Sin Coach
                                    </div>
                                </div>
                            </div>

                            <h3 class="modal-section-heading">
                                Inscritos en esta Clase
                            </h3>
                            <div class="card people-list" v-if="clase.assistants.length > 0">
                                <div class="item" v-for="user of clase.assistants" :key="user.id">
                                    <div class="img" v-bind:style="{ 'background-image': 'url(' + user.avatar + ')' }"></div>
                                    <div class="data">
                                        <h4 class="name">{{ user.full_name }}</h4>
                                        <!-- <h5 class="tag">{{ capitalizeFirstLetter(user.status.name) }}</h5> -->
                                        <h5 class="tag">{{ user.status.name }}</h5>

                                    </div>
                                </div>
                            </div>
                            <div class="card people-list" v-else>
                                Aún sin inscritos
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" v-if="(reserveStage == 4) && (stageLoaded)">
                        <span class="selected-class">{{ clase.clase_type.clase_type }}</span>
                        <!-- <span class="selected-date">{{ capitalizeFirstLetter(clase.date_human) }}</span> -->
                        <span class="selected-date">{{ clase.date_human }}</span>

                        <span class="selected-hour">{{ zonedHour(clase.start) }}</span>
                        <button class="primary"
                                @click="claseReserve()"
                                :disabled="!clase.auth.can_reserve || clase.auth.has_reserve"
                                v-bind:class="{'isDisabled' : (!clase.auth.can_reserve || clase.auth.has_reserve)}"
                        >
                            Reservar esta Clase
                        </button>
                        <button class="btn" @click="goToUrl(clase.url)">Detalles</button>
                    </div>

                </div>
            </div>
        </transition>
</div>
</template>

<script>
    import axios from 'axios';
    import moment from 'moment';
    import { mapGetters, mapActions } from 'vuex';

    export default {
        props: ['auth_timezone_difference'],
        data() {
            return {
                blocks: [],
                clase: null,
                modalShow: false,
                reserveStage: 1,
                stageLoaded: false,
                selectedType: [],
                selectedDay: [],
                selectedClase: [],
                types: [],
                week: [],
            }
        },
        mounted() {
            this.checkStage()
        },
        methods: {
            ...mapActions(['fetchClases','fetchClase','sendAlert', 'resetNextClases']),
            stageSub() {
                this.reserveStage--
                this.checkStage()
            },
            selectType(type) {
                    // console.log(type)
                    this.selectedType = type
                    this.reserveStage++
                    this.checkStage();
            },
            selectDay(day) {
                    // console.log(day)
                    this.selectedDay = day
                    this.reserveStage++
                    this.checkStage();
            },
            selectClase(clase) {
                    // console.log(clase)
                    this.selectedClase = clase
                    this.reserveStage++
                    this.checkStage();
            },
            /** Put just the first letter in Mayus, the rest all in minus */
            capitalizeFirstLetter(value) {
                value = value.toLowerCase();
                return value.charAt(0).toUpperCase() + value.slice(1);
            },
            checkStage() {
                switch (this.reserveStage) {
                case 1:
                    // console.log(this.reserveStage);
                    this.stageLoaded = false
                    axios.get('/clases/types').then(
                        response => {
                            // console.log(response.data)
                            this.types = response.data.types
                        }).then(res => {
                            this.stageLoaded = true
                        });
                    break;
                case 2:
                    this.stageLoaded = false
                    axios.get('/clases/week/'+ this.selectedType.id).then(
                        response => {
                            // console.log(response.data)
                            this.week = response.data.week
                    }).then(res => {
                        this.stageLoaded = true
                    })
                    .catch(e => {
                    console.log(e);
                    });
                    break;
                case 3:
                    this.stageLoaded = false
                    axios.get(`/clases/blocks/${this.selectedDay.date}?clase_type_id=${this.selectedType.id}`).then(
                        response => {
                            // console.log(response.data.blocks)
                            this.blocks = response.data.blocks
                    }).then(res => {
                        this.stageLoaded = true
                    })
                    .catch(e => {
                    console.log(e);
                    });
                    break;
                case 4:
                    this.stageLoaded = false
                    // console.log(this.selectedClase.id)
                    axios.get(`/clases/${this.selectedClase.id}/json`).then(
                        response => {
                            // console.log(this.selectedClase)
                            this.clase = response.data.clase
                    }).then(res => {
                        this.stageLoaded = true
                    })
                    .catch(e => {
                        console.log(e);
                    });

                    break;
                default:
                    // console.log(this.reserveStage);
                    break;
                }
            },
            claseReserve() {
                    axios.post('/clases/'+ this.selectedClase.id + '/reserve').then(
                        response => {
                            this.reserveStage = 1;
                            this.modalShow = false;
                            // this.fetchClases().then(() => {
                            //     this.sendAlert({
                            //         message: 'clase reservada con exito!',
                            //         class: 'success'
                            //     });
                            // });
                            this.resetNextClases().then(() => {
                                this.sendAlert({
                                    message: 'Clase reservada correctamente!',
                                    class: 'success'
                                })
                            });
                        }
                    ) .catch(e => {
                        console.log(e);
                    });
            },
            goToUrl(url) {
                window.location.href = url;
            },
            zonedHour(time) {
                if (this.auth_timezone_difference >= 0) {
                    return moment(time, 'HH:mm:ss').add(this.auth_timezone_difference, 'hours')
                                                    .format('HH:mm') + ' hrs.';
                }

                return moment(time, 'HH:mm:ss').subtract(this.auth_timezone_difference * -1, 'hours')
                                                .format('HH:mm') + ' hrs.';
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
    .slide-enter-active .right-modal {
        animation: to-left 0.5s forwards;
    }
    .slide-leave-active .right-modal {
        animation: to-right 0.5s forwards;
    }

 </style>
