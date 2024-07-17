<template>
    <footer class="bg-black ">
      <div class="px-7 py-8 md:px-10 lg:px-12 xl:px-16 1.5xl:px-[6vw] 2xl:px-0 2xl:mx-auto 2xl:max-w-7xl 3xl:max-w-8xl 4xl:max-w-9xl md:py-10 xl:py-12">
        <div class="text-[13px] md:text-[14px] tracking-tight grid gap-7 md:grid-cols-4 md:items-start">
          <div class="flex items-center gap-1.5 md:pt-1">
            <img class="w-6" :src="`${sport_center.box_image}`" :alt="`${sport_center.box_name}`" 
            />
            <span class="text-lg tracking-tight font-bold text-white">{{ sport_center.box_name }}</span>
          </div>
          <div>
            <p>
              <span class="text-white/50">Contáctanos</span>
              <br />
              <a class="text-white"
              :href="`mailto:${sport_center.box_email}`">{{ sport_center.box_email }}</a>
              <br />
              <a v-if="sport_center.box_whatsapp"
                  class="text-white"
                 :href="`https://wa.me/${sport_center.box_whatsapp}?text=hola!`"
                 target="_blank"
              >
                WhatsApp
              </a>
            </p>
          </div>
          <div v-if="sport_center.box_facebook || sport_center.box_instagram || sport_center.box_instagram">
            <p>
              <span class="text-white/50">Nuestras redes</span>
              <br />
              <a v-if="sport_center.box_facebook"
                 :href="sport_center.box_facebook"
                 class="text-white"
                 target="_blank"
              >
                Facebook
              </a>
              <br v-if="sport_center.box_facebook" />
              <a v-if="sport_center.box_instagram"
                 :href="sport_center.box_instagram"
                 class="text-white"
                 target="_blank"
              >
                Instagram
              </a>
              <br v-if="sport_center.box_instagram" />
              <a v-if="sport_center.box_instagram"
                 :href="sport_center.box_instagram"
                 class="text-white"
                 target="_blank"
              >
                TikTok
              </a>
              <br v-if="sport_center.box_instagram" />
            </p>
          </div>
            <div v-if="sport_center.box_address">
                <p class="text-white">
                <span class="text-white/50">Visítanos en</span>
                <br />
                {{ sport_center.box_address }}
                </p>
            </div>
        </div>
        
        <div>
          <div class="flex gap-1 justify-start mt-12 md:mt-16 lg:mt-20 pb-20 md:pb-0 md:items-center">
            <p class="text-[10px] md:text-[12px] text-white/60 tracking-tight">
              Con la tecnología de
            </p>
            <img :src="`${logo}`" alt="NFIT" class="h-[14px] md:h-[20px]" />
          </div>
        </div>
    </div>
    </footer>
  </template>
  
  <script>
  export default {
    props: {
      sport_center: {
        type: Object,
      },
    
    },
    data() {
      return {
        logo: window.location.origin +'/img/nfit-logo.png',
      }
    }
  };
  </script>
  