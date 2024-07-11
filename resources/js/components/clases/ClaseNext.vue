<template>
    <div>
        <div class="next-classes-dashboard section" v-if="confirmed_clases.length > 0">
            <div class="section-header">
                <!-- <h3 class="section-heading">Próximas Clases</h3> -->
                <h3 class="section-heading">Clases Confirmadas</h3>
            </div>
            <!-- Card Next Clases -->
            <a class="card-next-class"  v-for="clase in confirmed_clases.slice(0, 2)" :key="clase.id" :href="clase.url">
                <div class="card-next-class-container">
                    <div class="date">
                        <h2 class="number">{{ clase.day }}</h2>
                        <p class="month">{{ clase.month }}</p>
                    </div>
                    <div class="data">
                        <div class="header">
                            <div class="type">
                                <!-- <img :src="clase.clase_type.icon"> -->
                                <h3 class="name">{{ clase.clase_type.clase_type }}</h3>
                            </div>
                            <!-- <div class="tag" :class="clase.status.class">{{ clase.status.name }}</div> -->
                        </div>
                        <div class="body">
                            <p class="hour">{{ zonedHour(clase.start) }} - {{ zonedHour(clase.end) }}</p>
                            <p class="coach" v-if="clase.coach">Realizada por <span>{{ clase.coach.full_name }}</span></p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="next-classes-dashboard section" v-if="pending_clases.length > 0">
            <div class="section-header">
                <!-- <h3 class="section-heading">Próximas Clases</h3> -->
                <h3 class="section-heading">Clases Sin Confirmar</h3>
            </div>
            <!-- Card Next Clases -->
            <!-- <a href="/clases/clase.html" class="card-next-class">
                <div class="date">
                    <h2 class="number">29</h2>
                    <p class="month">ago</p>
                </div>
                <div class="data">
                    <div class="header">
                        <div class="type">
                            <img src="/assets/image/class-crossfit.png">
                            <h3 class="name">CrossFit</h3>
                        </div>
                        <div class="tag reserved">Reservada</div>
                    </div>
                    <div class="body">
                        <p class="hour">18:00 - 19:00 hrs</p>
                        <p class="coach">Realizada por <span>Roberto Pino</span></p>
                    </div>
                </div>
            </a> -->
            <a class="card-next-class"  v-for="clase in pending_clases.slice(0, 2)" :key="clase.id" :href="clase.url">
                <div class="card-next-class-container">
                    <div class="date">
                        <h2 class="number">{{ clase.day }}</h2>
                        <p class="month">{{ clase.month }}</p>
                    </div>
                    <div class="data">
                        <div class="header">
                            <div class="type">
                                <!-- <img :src="clase.clase_type.icon"> -->
                                <h3 class="name">{{ clase.clase_type.clase_type }}</h3>
                            </div>
                            <!-- <div class="tag" :class="clase.status.class">{{ clase.status.name }}</div> -->
                        </div>
                        <div class="body">
                            <p class="hour">{{ zonedHour(clase.start) }} - {{ zonedHour(clase.end) }}</p>
                            <p class="coach" v-if="clase.coach"> Realizada por <span>{{ clase.coach.full_name }}</span></p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <!-- Without confirm and pendient classes -->
        <div class="next-classes-dashboard section" v-if="confirmed_clases.length <= 0 && pending_clases <= 0">
            <div class="section-header">
                <!-- <h3 class="section-heading">Próximas Clases</h3> -->
                <h3 class="section-heading">Próximas Clases</h3>
            </div>
            <div class="card-no-data">
                <img src="/user/assets/icons/excercise-icon.svg" alt="Ejercicio">
                <p>
                    No tienes ninguna clase tomada
                </p>
            </div>
        </div>
        <!-- <div class="next-classes-dashboard section" v-if="confirmed_clases.length <= 0 && pending_clases <= 0">
            <div class="section-header">
                <h3 class="section-heading">Próximas Clases</h3>
                <h3 class="section-heading">Reserva una Clase</h3>
            </div> -->
            <!-- Card Next Clases -->
            <!-- <a class="card-next-class"  v-for="clase in suggested_clases" :key="clase.id" :href="clase.url">
                <div class="card-next-class-container">
                    <div class="date">
                        <h2 class="number">{{ getDayFromDate(clase.short_date) }}</h2>
                        <p class="month">{{ getMonthFromDate(clase.short_date) }}</p>
                    </div>
                    <div class="data">
                        <div class="header">
                            <div class="type">
                                <h3 class="name">{{ clase.clase_type.clase_type }}</h3>
                            </div>
                        </div>
                        <div class="body">
                            <p class="hour">{{ clase.start_at }} - {{ clase.finish_at }} hrs</p>
                            <p class="coach" v-if="clase.coach">Realizada por <span>{{ clase.coach.full_name }}</span></p>
                        </div>
                    </div>
                </div>
                <button>Reserva esta Clase</button>
            </a>
        -->

    </div>

</template>

<script>
    import axios from 'axios';
    import { mapGetters, mapActions } from 'vuex'
    export default {
        props: ['auth_timezone_difference',
                'suggestedClases'
        ],
        data() {
            return {
                monthNames: [
                    "ene", "feb", "mar", "abr", "may", "jun",
                    "jul", "ago", "sep", "oct", "nov", "dic"
                ],
                pending_clases: [],    // The classes with status "PENDIENTE"
                confirmed_clases: [],  // The classes with status "CONFIRMADA"
                suggested_clases: [],  // Possible classes the student would like to take
            }
        },
        mounted() {
            // Get all clases of the authenticated user
            // this.getNextTwoClases();
            console.log( 'clases sugeridas',this.suggested_clases);

            this.fetchClases().then(() => {
                if (this.nextClases.length <= 0) {
                    this.fetchSuggestedClases();
                }
                /**  Filter for all clases, only with the status "PENDIENTE" */
                this.pending_clases = this.nextClases.filter(el => el.status.id == '1');
                /**  Filter for all clases, only with the status "CONFIRMADA" */
                this.confirmed_clases = this.nextClases.filter(el => el.status.id == '2');
            });
            // }).then(() => {
            //     console.log(this.pending_clases)
            //     console.log(this.confirmed_clases)
            // });
        },
        computed: {
            ...mapGetters(['nextClases']),
            
        },
        methods: {
            ...mapActions(['fetchClases']),
            fetchSuggestedClases() {
                // axios.get('/u/clases/next-clases').then(response => {
                //     this.suggested_clases = response.data.next_clases;
                    // console.log(response.data.next_clases);
                // });
                this.suggested_clases = this.suggestedClases;
            },
            /**
             *  Return day number of an date
             *
             *  @param  date  01/01/20
             *
             *  @return  integer  01
             */
            getDayFromDate(date) {
                return date.slice(0, 2);
            },
            /**
             *  Return day number of an date
             *
             *  @param  date  01/01/20
             *
             *  @return  string  dic
             */
            getMonthFromDate(date) {
                return this.monthNames[date.slice(3, 5)];
            },
            zonedHour(time) {
                if (this.auth_timezone_difference >= 0) {
                    return moment(time, 'HH:mm:ss').add(this.auth_timezone_difference, 'hours')
                                                    .format('HH:mm');
                }

                return moment(time, 'HH:mm:ss').subtract(this.auth_timezone_difference * -1, 'hours')
                                                .format('HH:mm');
            },
        }

    }
</script>
