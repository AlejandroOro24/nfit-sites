<template>
    <div :style="{ backgroundImage: `url(${sport_center.box_banner})` }" class="bg-center bg-cover bg-no-repeat relative after:content-[''] after:absolute after:z-10 after:inset-0 after:w-full after:h-full after:bg-black/90 after:block">
      <div class="relative z-20 xl:flex xl:flex-wrap xl:items-end xl:justify-between py-12 md:py-16 xl:py-20 px-6 md:px-10 lg:px-12 xl:px-16 1.5xl:px-[6vw] 2xl:px-0 2xl:mx-auto 2xl:max-w-7xl 3xl:max-w-8xl 4xl:max-w-9xl">
        <header class="mx-auto lg:mx-0 mb-7 w-11/12 md:w-full">
          <h2 class="text-2xl md:text-3xl tracking-tight font-bold text-center lg:text-left mb-2">
            <span class="text-brand">Reserva gratis</span> esta semana
          </h2>
          <p class="text-[13px] text-white/80 text-center lg:text-left tracking-tight">
            <span class="font-semibold text-white">Sólo para nuevos clientes</span>. Ven gratis a {{ sport_center.box_name }} reservando una hora aquí
          </p>
        </header>
        <div class="flex gap-2 flex-wrap lg:flex-nowrap lg:w-full xl:w-9/12">
          <div class="grid gap-2 md:grid-cols-3 w-full">
            
            <Discipline 
                :clase-type-name="clase_type" 
                @activeButton="handleActiveDate" 
                @updateDiscipline="updateDiscipline" />
            
             <Date 
                :actived="activeDate" 
                @activeTime="handleActiveTime" 
                @updateDate="updateDate" 
                :date_clases="shortDateArray" />
            
           <Time 
                :actived="activeTime" 
                @activeDiscipline="handleActiveButton" 
                @updateTime="updateTime" 
                :schedules="arrayFiltred" />

          </div>

          <button :class="{ 'disabled': !activeButton }" class="button mt-0.5 w-full !px-5 md:inline-block md:w-auto md:mx-auto lg:mx-0" @click="goToReservation">
            <span class="whitespace-nowrap">Reserva tu hora</span>
          </button>
          
        </div>

        <div class="flex gap-1 items-center justify-center lg:justify-start mt-7 md:mt-10 lg:mt-7 lg:pl-0.5 -space- xl:3/12 xl:mt-0 xl:mb-0.5">
          <p class="text-[10px] text-white/60 tracking-tight">Con la tecnología de</p>
          <img :src="`${asset}/nfit-logo.png`" alt="NFIT" class="h-[14px]" />
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import Discipline from './Discipline.vue'
  import Date from './Date.vue'
  import Time from './Time.vue'
  
  export default {
    name: 'TestReservation',
    components: {
      Discipline,
      Date,
      Time
    },
    props: {
     sport_center: {},
      asset: String,
      clase_type: {},
      clases: {}
    },
    data() {
      return {
        activeTime: false,
        activeDate: false,
        activeButton: false,
        date: '',
        time: '',
        discipline: { id: '', clase_type: '' }
      }
    },
    computed: {
      filtredClaseTypeId() {
        return this.clases.filter(item => item.clase_type_id === this.discipline.id)
      },
      shortDateArray() {
        return this.filtredClaseTypeId.map(item => item.short_date)
      },
      arrayFiltred() {
        console.log(this.date)
        console.log(this.clases.filter(item => item.clase_type_id === this.discipline.id && item.short_date === this.date)
        .map(item => item.start_at))
        return this.clases.filter(item => item.clase_type_id === this.discipline.id && item.short_date === this.date)
          .map(item => item.start_at)
      },
      classIds() {
        return this.clases.filter(item => item.clase_type_id === this.discipline.id && item.short_date === this.date && item.start_at === this.time)
          .map(item => item.id)
      }
    },
    methods: {
      updateDate(value) {
        this.date = value
      },
      updateTime(value) {
        this.time = value
      },
      updateDiscipline(value) {
        this.discipline = value
      },
      handleActiveTime(value) {
        this.activeTime = value
      },
      handleActiveDate(value) {
        this.activeDate = value
      },
      handleActiveButton(value) {
        this.activeButton = value
      },
      goToReservation() {
        if (this.activeButton) {
          const id = this.classIds
          const reserveRoute = `/trial/${id}`
          window.location.href = reserveRoute
        }
      }
    }
  }
  </script>