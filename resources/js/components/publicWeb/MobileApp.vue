<template>
    <section class="bg-midBlack bg-center bg-cover " :style="`background-image: url(${back_img})`">
      <div class="pt-8 pb-10 md:pt-12 md:pb-12 px-7 md:px-10 lg:px-12 xl:px-16 1.5xl:px-[6vw] 2xl:px-0 2xl:mx-auto 2xl:max-w-7xl 3xl:max-w-8xl 4xl:max-w-9xl grid gap-7 md:grid-cols-2 md:items-center">
        <div class="md:order-2 md:pl-7 xl:pl-20">
          <img :src="`${app_img}`" alt="NFIT App" />
        </div>
        <div class="md:order-1">
          <img :src="`${logo_img}`" alt="NFIT Logo" class="mb-4 lg:mb-5 lg:h-8" />
          <h2 class="text-3xl lg:text-4xl font-bold text-white   tracking-tight  mb-4 lg:mb-5 lg:w-[16ch]">
            Con NFIT reserva tus clases en FullFit
          </h2>
          <p class="tracking-tight text-white/70 text-sm mb-5 lg:mb-6 lg:w-[48ch]">
            FullFit funciona con la tecnología de NFIT, con la app puedes reservar y confirmar tu asistencia, gestionar tu membresía entre otras funciones.
          </p>
          <div class="flex flex-wrap gap-2 lg:w-[40ch] xl:w-[50ch]">
            <a href="https://apps.apple.com/app/nfit/id1458653773" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 bg-nfit text-black font-bold uppercase text-[11px] py-2.5 border border-nfit rounded-md px-4 transition hover:bg-nfit/90 hover:border-nfit/90">
              <img :src="`${apple_img}`" alt="Apple App store" class="inline w-auto mb-0.5" />
              <span class="after:content-['→'] after:ml-1 tracking-tight">Descarga en App Store</span>
            </a>
            <a href="https://play.google.com/store/apps/details?id=com.asomic.nfit" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 bg-nfit text-black font-bold uppercase text-[11px] py-2.5 border border-nfit rounded-md px-4 transition hover:bg-nfit-light/90 hover:border-nfit/90">
              <img :src="`${google_img}`" alt="Google Play store" class="inline w-auto mb-0.5" />
              <span class="after:content-['→'] after:ml-1 tracking-tight">Descarga en Google Play</span>
            </a>
          </div>
        </div>
      </div>
    </section>
  </template>
  
  <script>
  export default {
    props: {

    },
    data() {
        return {
            app_img:this.asset("/img/nfit-app.png"),
            logo_img:this.asset("/img/nfit-logo.png"),
            apple_img:this.asset("/img/icon_apple.png"),
            google_img:this.asset("/img/icon_google_play.png"),
            back_img:this.asset("/img/nfit-app-back.jpg"),

        }
    },
    methods: {
        asset(path) {
            return window.location.origin + path;
        }
    }
};
  </script>
  