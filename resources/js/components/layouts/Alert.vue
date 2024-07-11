<template>
        <div class="toasts" >
            <transition name="fade">
            <div class="toast d-inherit" v-if="alert">
                <p>
                </p>
            </div>
            </transition>
        </div>
    
</template>

<script>
    import { mapGetters, mapActions } from 'vuex' 

    export default {
        data() {
            return {

            }
        },
        mounted() {
            //
        },
        computed: {
            ...mapGetters(['alert'])
        },
        methods:{
            ...mapActions(['removeClase']),
        } 
}
</script>

<style scoped>
    .fade-enter-active, .fade-leave-active {
        transition: opacity 0.5s;
    }
    .fade-enter, .fade-leave-to {
        opacity: 0 !important;
    }
</style>
