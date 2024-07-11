<template>
    <section class="section next-classes" >
        <div class="section-header">
            <h3 class="section-heading">Cupos</h3>
        </div>
        <div class="grid space-available">
            <div class="col-9 item reserved">
                <span class="space-number" v-if="clase" >{{clase.quorum}}</span>
                <h5 class="space-name">Reservados</h5>
            </div>
            <div class="col-9 item available">
                <span class="space-number" v-if="clase" >{{clase.available}}</span>
                <h5 class="space-name">Disponibles</h5>
            </div>
        </div>
    </section>
    
</template>

<script>
    import { mapGetters, mapActions } from 'vuex' 
    export default {
        props: {
            claseId: String,
        },
        mounted() {
        },
        computed: {
            ...mapGetters(['clase'])
        },
        methods:{
            ...mapActions(['fetchClase']),
        } 

    }
</script>


