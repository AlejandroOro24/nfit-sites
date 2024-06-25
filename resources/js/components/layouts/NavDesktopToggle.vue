<template>
  <div class="desktop-collapse" id="desktopToggler" v-on:click="collapseHandler()">
      <span class="icon-arrow" v-bind:class="{ collapsed: navDesktopStatus }"></span><!-- Icon collapse -->
  </div>
</template>

<script>
    export default {
    data() {
        return {
            navDesktopStatus: false
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
            const aside = document.querySelector('#aside');
            const main = document.querySelector('main');

            if(localStorage.getItem('desktopNavCollapsed') === "true" ) {
                this.navDesktopStatus = false;
                localStorage.setItem('desktopNavCollapsed', false);
                aside.classList.remove('desktop-collapsed');
                main.classList.remove('full-spacing');
              
            } else {
                this.navDesktopStatus = true;
                localStorage.setItem('desktopNavCollapsed', true);
                aside.classList.add('desktop-collapsed');
                main.classList.add('full-spacing');
            }
        }
      } 
    }
</script>
