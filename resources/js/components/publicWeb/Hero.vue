<template>
     <div
        class="hero h-[90dvh] md:h-[85dvh] flex justify-center items-center px-5 bg-cover bg-center"
        :style="{ backgroundImage: `url(${sport_center.box_banner})` }"
      >
        <div class="text-center pt-12 md:pt-5">
          <img
            :src="sport_center.box_image"
            alt="banner"
            class="h-20 w-20 rounded-full m-auto mb-5 md:mb-6"
          />
          <h1 class="font-bold text-2.5xl text-white md:text-3xl lg:text-4xl tracking-tight mx-auto mb-5 example max-w-[22ch] leading-snug lg:leading-tight">
              {{sport_center.first_sentence}}
          </h1>
          <p class="text-sm text-white/70 tracking-tight mb-6 inline-block w-11/12 max-w-[46ch] md:leading-normal">
              {{sport_center.secondary_sentence}}
          </p>
          <div class="flex justify-center gap-2.5">
            <a href="#" class="button">
              Clase de prueba
            </a>
            <a href="#" class="button b-outline">
              Revisa los planes
            </a>
          </div>
        </div>
      </div>
</template>

<script>
    export default {
      name: 'PublicHero',
        props: {
            sport_center: {},
        },
    }
            
</script>