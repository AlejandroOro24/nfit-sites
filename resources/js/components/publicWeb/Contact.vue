<template>
    <section class="bg-black" id="section-contact">
      <div class="py-9 px-8 md:px-10 lg:px-12 xl:px-16 1.5xl:px-[6vw] 2xl:px-0 2xl:mx-auto 2xl:max-w-7xl 3xl:max-w-8xl 4xl:max-w-9xl md:py-12 md:grid md:grid-cols-8 md:gap-4 xl:min-h-[470px]">
        <!-- Mapa -->
        <div class="w-full h-[300px] md:h-[100%] md-[100%] relative rounded-lg overflow-hidden mb-3 md:mb-0 md:col-start-1 md:col-end-6 lg:col-end-7">
          <iframe
            id="gmap_canvas"
            :src="`https://maps.google.com/maps?q=${mapAddress}&z=17&ie=UTF8&iwloc=&output=embed`"
            class="w-full h-full"
            frameborder="0"
            scrolling="no"
            marginheight="0"
            marginwidth="0"
          ></iframe>
        </div>
        <div class="grid gap-3 md:col-start-6 lg:col-start-7 md:col-end-9">
          <!-- Visítanos -->
          <div class="bg-midBlack rounded-lg pt-4 pb-5 lg:pt-5 lg:pb-6 px-5">
            <h3 class="text-lg font-bold text-white tracking-tight mb-1">Visítanos</h3>
            <p class="text-[13px] tracking-tight text-white/70 leading-normal">
              {{ contact.box_address }}
            </p>
          </div>
          <!-- Horarios -->
          <div class="bg-midBlack rounded-lg py-4 pb-5 lg:pt-5 lg:pb-6 px-5">
            <h3 class="text-lg font-bold text-white tracking-tight mb-1">Horarios</h3>
            <div v-html="contact.box_schedules" class="text-[13px] tracking-tight text-white/70 leading-normal"></div>
          </div>
        </div>
      </div>
    </section>
  </template>
  
  <script>
  import { ref } from 'vue';
  
  export default {
    props: {
      contact: {
        type: {},
        required: true
      }
    },
    computed: {
      mapAddress() {
        console.log(this.contact);
        return `${this.contact._box_name} ${this.contact.box_address}`;
      }
    }
  };
  </script>
  