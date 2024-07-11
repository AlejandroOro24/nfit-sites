<template>
    <section class="bg-midBlack">
      <div
        class="
          pt-4
          md:pt-5
          lg:pt-6
          xl:pt-7
          px-8
          lg:px-12
          xl:px-16
          1.5xl:px-[6vw]
          2xl:px-0
          2xl:mx-auto
          2xl:max-w-7xl
          3xl:max-w-8xl
          4xl:max-w-9xl
          pb-6
          md:pb-7
          lg:pb-8
          xl:pb-9
        "
      >
        <div
          class="
            bg-black
            rounded-lg
            flex
            justify-center
            flex-wrap
            gap-x-3
            md:gap-x-7
            lg:gap-x-9
            xl:gap-x-12
            gap-y-2.5
            py-6
            px-4
          "
        >
          <h3 class="text-[14px] lg:text-[15px] text-brand font-bold mb-1.5 md:mb-0">
            Todos los planes incluyen
          </h3>
          <div v-for="(amenity, key) in amenities" :key="key" class="flex gap-2">
            <div v-html="amenity.icon" class="amenity-icon w-4 h-4"></div>
            <p class="text-[13px] lg:text-[15px] font-semibold tracking-tight">
              {{ amenity.name }}
            </p>
          </div>
        </div>
      </div>
    </section>
  </template>
  
  <script>

  export default {
    name: 'Amenities',
    props: {
      amenities: {
        type: Array,
        required: true
      }
    },
//     data() {
//     return {
//       // Asigna el array de amenities importado a la propiedad local amenities
//       localAmenities: amenities
//     };
//   }
  };
  </script>