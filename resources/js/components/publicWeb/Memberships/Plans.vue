<template>
    <div class="bg-midBlack" id="section-memberships">
      <div class="pt-9 pb-1 md:pt-10 xl:pt-12 1.5xl:pt-14">
        <header class="md:flex md:justify-between md:px-9 lg:px-12 xl:px-16 1.5xl:px-[6vw] 2xl:px-0 2xl:mx-auto 2xl:max-w-7xl 3xl:max-w-8xl 4xl:max-w-9xl">
          <h2 class="text-2xl lg:text-3xl tracking-tight font-bold text-center text-white mb-6 lg:mb-8 lg:ml-0.5 xl:ml-1">Planes</h2>
          <!-- Filter -->
          <div class="w-min flex m-auto md:mx-0 text-[11px] border border-white/20 rounded-full mb-6 lg:mb-8">
            <div
              v-for="p in periods"
              :key="p"
              :class="['py-2 px-5 rounded-full cursor-pointer border text-white hover:bg-black', { 'border-white/40 bg-black transition duration-300': period === p, 'border-white/0': period !== p }]"
              @click="setPeriod(p)"
            >
              {{ p }}
            </div>
          </div>
        </header>

        <section class="2xl:px-0 2xl:mx-auto 2xl:max-w-[1440px] 3xl:max-w-[1580px] 4xl:max-w-[1690px]">
          <!-- Cards -->
          <section class="slider-wrapper overflow-hidden relative">
            <button class="slide-arrow membership-slide-arrow-prev" @click="slideLeft">
              &#8249;
            </button>
            <button class="slide-arrow membership-slide-arrow-next" @click="slideRight">
              &#8250;
            </button>
            <ul class="memberships-slides-container overflow-x-scroll overflow-y-hidden" id="slides-container" ref="slidesContainerRef">
              <!-- Slide -->
              <li
                v-for="(membership, index) in filteredPlans"
                :key="index"
                class="memberships-slide px-1.5"
                ref="slideRefs"
              >
                <div class="bg-black pt-6 px-6 pb-6 rounded-xl">
                  <header class="border-b border-gray-800 pb-4">
                    <h3 class="text-base lg:text-lg font-bold text-white tracking-tight">{{ membership.plan }}</h3>
                  </header>
                  <div class="features">
                    <Feature> <span>X reservas</span> </Feature>
                    <Feature> <span>{{ membership.schedule_days }}</span> </Feature>
                    <Feature> <span>{{ membership.schedule_hours }}</span> </Feature>
                    <Feature> <span>Reserva a través de la app</span> </Feature>
                    <Feature> <span>Paga tu plan a través de la app</span> </Feature>
                  </div>
                  <div class="price">
                    <p>
                      {{ formatPrice(membership.amount) }} <span>{{ periodSuffix(membership.period) }}</span>
                    </p>
                  </div>
                  <button class="w-full button mt-0.5" @click="goToReservation(membership.id)">
                    Contrata aquí
                  </button>
                </div>
              </li>
            </ul>
          </section>
        </section>
      </div>
    </div>
  </template>
  
  <script>
  import Feature from './Feature.vue';
//   import formatPrice from '../../utils/FormatPrice';
  
  export default {
    name: 'Memberships',
    components: {
      Feature
    },
    props: {
      memberships: {},
    },
    data() {
      return {
        scrollPosition: 0,
        period: 'Mensual',
        plans: this.memberships,
        periods: ['Mensual', 'Trimestral', 'Semestral', 'Anual']
      };
    },
    computed: {
      filteredPlans() {
        const periodIndex = this.periods.indexOf(this.period) + 1;
        return this.plans.filter(plan => plan.plan_period_id === periodIndex);
      }
    },
    watch: {
      memberships: {
        immediate: true,
        handler(newVal) {
          this.plans = newVal;
        }
      },
      period() {
        this.resetScrollPosition();
      }
    },
    methods: {
      setPeriod(p) {
        this.period = p;
      },
      resetScrollPosition() {
        this.scrollPosition = 0;
        this.$refs.slidesContainerRef.scrollTo({
          left: 0,
          behavior: 'smooth'
        });
      },
      slideRight() {
        const slideWidth = this.$refs.slideRefs[0]?.clientWidth || 0;
        const scrollWidth = this.$refs.slidesContainerRef.scrollWidth || 0;
        const maxScroll = scrollWidth - slideWidth || 0;
  
        const newPosition = this.scrollPosition + slideWidth;
        if (newPosition <= maxScroll) {
          this.scrollPosition = newPosition;
          this.$refs.slidesContainerRef.scrollTo({
            left: newPosition,
            behavior: 'smooth'
          });
        }
      },
      slideLeft() {
        const slideWidth = this.$refs.slideRefs[0]?.clientWidth || 0;
        const newPosition = this.scrollPosition - slideWidth;
  
        this.scrollPosition = newPosition < 0 ? 0 : newPosition;
  
        this.$refs.slidesContainerRef.scrollTo({
          left: newPosition < 0 ? 0 : newPosition,
          behavior: 'smooth'
        });
      },
      goToReservation(id) {
        const reservationRoute =  window.routes.registerBuy
        .replace(':id', id);

        window.location.href = reservationRoute;
      },
      periodSuffix(period) {
        return period === 'Mensual'
          ? '/mes'
          : period === 'Trimestral'
          ? '/trimestre'
          : period === 'Semestral'
          ? '/semestre'
          : period === 'Anual'
          ? '/año'
          : '';
      },

     formatPrice (price)  {
        const formatedPrice = new Intl.NumberFormat("es-CL").format(price);
        return `${formatedPrice}`;
        }
    }
  };
  </script>