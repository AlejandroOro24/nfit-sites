<template>
    <div>
        <div class="card-today-routines" v-if="wods.length > 0">
        <!-- Wrapper routines -->
            <div class="today-routines slider-routines">
                <!-- Una Rutina -->
                    <div v-for="wod of wods" :key="wod.id" class="class-routine slide" :id="'slide-'+ wod.id">
                        <h3 class="class-name">
                            {{ wod.clase_type.clase_type }}
                        </h3>

                        <stages :wodId="wod.id"></stages>
                    </div>
            </div>
            <div class="navigation">
                <a v-for="wod of wods"
                    :key="wod.id"
                    :href="'#slide-'+ wod.id"
                    @click="activeWod(wod)"
                    v-bind:clase="{active: activeWodId == wod.id}"
                >
                </a>
            </div>
        </div>

        <!-- Without routine -->
        <div class="card-no-data" v-else>
            <img src="/user/assets/icons/excercise-icon.svg" alt="Ejercicio">

            <p>No hay rutinas para mostrar</p>
        </div>
    </div>

</template>

<script>
    import axios from 'axios'

    export default {
        props: {
            wods: {},
        },
        data() {
            return {
                // wods: [],
                activeWodId: 0,
            }
        },
        mounted() {
            // this.fetchWodsToday();
        },
        methods:{
            // fetchWodsToday() {
            //     axios.get('/u/wods/today').then(
            //         response => this.manageSuccessWodsResponse(response)
            //     );
            // },
            // manageSuccessWodsResponse(response) {
            //     if (this.thereAreWodsInThis(response)) {
            //         this.fillTheWods(response.data.wods);

            //         this.activateFirstWod(response.data.wods[0]);
            //     }
            // },
            // thereAreWodsInThis(response) {
            //     return !! response.data.wods.length >= 1; // that means array wods has a index of 0
            // },
            // fillTheWods(wods) {
            //     this.wods = wods;
            // },
            // activateFirstWod(wod) {
            //     this.activeWodId = wod ? wod.id : 0;
            // },
        }
    }
</script>
