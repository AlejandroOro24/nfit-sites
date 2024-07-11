<template>
    <div :class="{'effect-visible': !floatingStatus, 'effect-invisible': floatingStatus}">
      <div class="fixed z-30 w-max left-0 md:left-auto right-0 md:right-10 lg:right-12 xl:right-16 1.5xl:right-[6vw] 2xl:right-[8vw] 3xl:right-[9vw] 4xl:right-[12vw] 5xl:right-[20vw] bottom-6 md:bottom-7 m-auto text-[13px] bg-[#25D366] text-black font-semibold tracking-tight inline-flex justify-center gap-1 items-center rounded-full">
        <a :href="`https://wa.me/${sport_center.box_whatsapp}?text=hola!`" target="_blank" class="flex gap-1.5 items-center h-12 pl-6">
          <img :src="`${whatsapp_img}`" alt="Icono WhatsApp" class="w-4 h-4 mb-0.5" />
          <span>Háblanos al WhatsApp</span>
        </a>
        <div class="flex justify-center items-center w-7 h-7 bg-[length:50%_50%] bg-center bg-no-repeat cursor-pointer mr-3 " :style="`background-image: url(${close_img})`" @click="closeFloating"></div>
      </div>
    </div>
  </template>
  
  <script>
import { setLocalStorage, getLocalStorage } from '@/utils/localStorageWithExpiry';
  
  export default {
    props: {
      sport_center: {}
    },
    data() {
      return {
        whatsapp_img: window.location.origin +'/img/icon-whatsapp.png',
        close_img: window.location.origin +'/img/icon-close.png',
        // floatingStatus: VueLocalStorage.get('floating', false)
        floatingStatus: getLocalStorage('floating') !== null ? getLocalStorage('floating') : false

      };
    },
    methods: {
      closeFloating() {
        this.floatingStatus = true;
        setLocalStorage('floating', this.floatingStatus, 5000);
        
    }
    },
    watch: {
      floatingStatus(newStatus) {
        console.log(newStatus);
      }
    },
    mounted() {
        if (this.floatingStatus) {
            setLocalStorage('floating', this.floatingStatus, 5000); 
        }
    }
  };
  </script>
  
  <style scoped>
  .effect-visible {
    visibility: visible;
    opacity: 1;
    transition: opacity 0.5s, visibility 0.5s;
  }
  
  .effect-invisible {
    visibility: hidden;
    opacity: 0;
    transition: opacity 0.5s, visibility 0.5s;
  }
  </style>