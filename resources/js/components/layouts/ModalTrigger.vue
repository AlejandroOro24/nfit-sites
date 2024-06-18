<template>
    <button class="btn primary small trigerModal-confirm">Confirmar</button>
</template>

<script>
    export default {
        props: [
            'class',
            'modal',
            'text'
        ], 
        data() {
            return {

            }
        },
        mounted() {
            if(localStorage.getItem('desktopNavCollapsed') === "true" ) {
                this.navDesktopStatus = true;
            } else {
                this.navDesktopStatus = false;
            }
        },
        methods:{
            collapseHandler() {

            }
        } 
}
</script>
