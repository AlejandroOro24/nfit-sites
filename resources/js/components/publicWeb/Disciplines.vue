<template>
    <div class="bg-black">
      <div class="px-1 lg:px-3 pb-10 lg:pb-12 2xl:px-0 2xl:mx-auto 2xl:max-w-[1440px] 3xl:max-w-[1580px] 4xl:max-w-[1780px]">
        <h2 class="text-2xl lg:text-3xl tracking-tight font-bold text-center text-white mb-10">
          ¿Qué hacemos en {{ sport_center.box_name }}?
        </h2>
        <section class="slider-wrapper overflow-hidden relative">
          <button
            class="slide-arrow slide-arrow-prev"
            id="slide-arrow-prev"
            @click="slideLeft"
          >
            &#8249;
          </button>
          <button
            class="slide-arrow slide-arrow-next"
            id="slide-arrow-next"
            @click="slideRight"
          >
            &#8250;
          </button>
          <ul
            class="disciplines-slides-container overflow-x-scroll overflow-y-hidden"
            id="slides-container"
            ref="slidesContainerRef"
          >
            <li
              v-for="(discipline, index) in disciplines"
              :key="index"
              class="disciplines-slide"
              :ref="setSlideRef(index)"
            >
              <div
                class="disciplines-slide-content bg-center bg-cover bg-no-repeat"
                :style="{ backgroundImage: `url(${discipline.image})` }"
              >
                <div>
                  <header class="flex justify-between items-center mb-2">
                    <p class="font-bold tracking-tight text-lg text-white">
                      {{ discipline.clase_type }}
                    </p>
                    <img class="w-8 h-8 text-white" :src="discipline.icon" alt="" />
                  </header>
                  <p class="text-[13px] text-white w-11/12 opacity-80">
                    "Se sueño entusiasmado más para menos jardineros, a del datan una a segmento, más para menos jardineros, a del datan una a segmento. (max ch.)"
                  </p>
                </div>
              </div>
            </li>
          </ul>
        </section>
      </div>
    </div>
  </template>
  
  <script>
  import { ref } from 'vue';
  
  export default {
    name: 'Disciplines',
    props: {
      disciplines: {},
      sport_center: {}
    },
    setup() {
      const scrollPosition = ref(0);
      const slidesContainerRef = ref(null);
      const slideRefs = ref([]);
  
      const setSlideRef = (index) => (el) => {
        slideRefs.value[index] = el;
      };
  
      const slideRight = () => {
        const slideWidth = slideRefs.value[0]?.clientWidth || 0;
        const scrollWidth = slidesContainerRef.value?.scrollWidth || 0;
        const maxScroll = scrollWidth - slideWidth || 0;
        const newPosition = scrollPosition.value + slideWidth;
  
        if (newPosition <= maxScroll) {
          scrollPosition.value = newPosition;
          slidesContainerRef.value?.scrollTo({
            left: newPosition,
            behavior: 'smooth',
          });
        }
      };
  
      const slideLeft = () => {
        const slideWidth = slideRefs.value[0]?.clientWidth || 0;
        const newPosition = scrollPosition.value - slideWidth;
        scrollPosition.value = newPosition < 0 ? 0 : newPosition;
        slidesContainerRef.value?.scrollTo({
          left: newPosition < 0 ? 0 : newPosition,
          behavior: 'smooth',
        });
      };
  
      return {
        scrollPosition,
        slidesContainerRef,
        slideRefs,
        setSlideRef,
        slideRight,
        slideLeft
      };
    }
  };
  </script>