<template>
    <header
      :class="['header fixed top-0 z-30 transition duration-300 w-full', opened ? 'bg-black md:bg-black/70' : 'bg-black/70']"
      id="section-header"
    >
      <div class="px-5 md:px-10 lg:px-12 xl:px-16 1.5xl:px-[6vw] 2xl:px-0 2xl:mx-auto 2xl:max-w-7xl 3xl:max-w-8xl 4xl:max-w-9xl pt-6 md:py-6 w-full md:flex md:items-center md:justify-between">
        <!-- Header content -->
        <div class="flex justify-between items-center gap-5 md:gap-8 pb-6 md:pb-0">
          <!-- Branding -->
          <a href="/" class="flex items-center gap-2">
            <img :src="sport_center.box_image" alt="Logo" class="w-6 h-6 rounded-full" />
            <h2 class="font-bold text-lg text-white tracking-tight">{{ sport_center.box_name }}</h2>
          </a>
          <!-- RRSS -->
          <div
            v-if="sport_center.box_facebook|| sport_center.box_instagram|| sport_center.box_instagram"
            class="flex items-center gap-2.5 md:gap-5 justify-end flex-grow"
          >
            <!-- Instagram -->
            <a v-if="sport_center.box_instagram" :href="`https://www.instagram.com/${sport_center.box_instagram}`" target="_blank">
              <svg
                width="16"
                height="16"
                viewBox="0 0 14 14"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
                class="icon"
              >
                <path
                  d="M4.23684 0C1.90341 0 0 1.90341 0 4.23684V9.76316C0 12.0963 1.90334 14 4.23684 14H9.76316C12.0963 14 14 12.0963 14 9.76316V4.23684C14 1.90334 12.0963 0 9.76316 0H4.23684ZM4.23684 1.10526H9.76316C11.4989 1.10526 12.8947 2.50077 12.8947 4.23684V9.76316C12.8947 11.4988 11.4988 12.8947 9.76316 12.8947H4.23684C2.50077 12.8947 1.10526 11.4989 1.10526 9.76316V4.23684C1.10526 2.5007 2.5007 1.10526 4.23684 1.10526ZM10.6842 2.57895C10.2771 2.57895 9.94737 2.90868 9.94737 3.31579C9.94737 3.72289 10.2771 4.05263 10.6842 4.05263C11.0913 4.05263 11.4211 3.72289 11.4211 3.31579C11.4211 2.90868 11.0913 2.57895 10.6842 2.57895ZM7 3.31579C4.97191 3.31579 3.31579 4.97191 3.31579 7C3.31579 9.02809 4.97191 10.6842 7 10.6842C9.02809 10.6842 10.6842 9.02809 10.6842 7C10.6842 4.97191 9.02809 3.31579 7 3.31579ZM7 4.42105C8.43064 4.42105 9.57895 5.56936 9.57895 7C9.57895 8.43064 8.43064 9.57895 7 9.57895C5.56936 9.57895 4.42105 8.43064 4.42105 7C4.42105 5.56936 5.56936 4.42105 7 4.42105Z"
                />
              </svg>
            </a>
            <!-- Facebook -->
            <a v-if="sport_center.box_facebook" :href="`https://www.facebook.com/${sport_center.box_facebook}`" target="_blank">
              <svg
                width="16"
                height="16"
                viewBox="0 0 14 14"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
                class="icon"
              >
                <path
                  d="M7 0C3.13409 0 0 3.1502 0 7.03598C0 10.5636 2.58523 13.4761 5.95382 13.985V8.90083H4.22195V7.05133H5.95382V5.82067C5.95382 3.78312 6.94145 2.88859 8.62623 2.88859C9.43314 2.88859 9.85982 2.94871 10.0619 2.97622V4.59066H8.91259C8.19732 4.59066 7.94755 5.27219 7.94755 6.04039V7.05133H10.0437L9.75927 8.90083H7.94755V14C11.3642 13.534 14 10.5978 14 7.03598C14 3.1502 10.8659 0 7 0Z"
                />
              </svg>
            </a>
            <!-- Tiktok -->
            <a v-if="sport_center.box_instagram" :href="`https://www.tiktok.com/${sport_center.box_instagram}`" target="_blank">
              <svg
                width="16"
                height="16"
                viewBox="0 0 14 14"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
                class="icon"
              >
                <path
                  d="M12.3333 0H1.66667C0.747667 0 0 0.747667 0 1.66667V12.3333C0 13.2523 0.747667 14 1.66667 14H12.3333C13.2523 14 14 13.2523 14 12.3333V1.66667C14 0.747667 13.2523 0 12.3333 0ZM11.002 6.10767C10.9263 6.11467 10.8497 6.11933 10.772 6.11933C9.89767 6.11933 9.12933 5.66967 8.68233 4.99C8.68233 6.773 8.68233 8.80167 8.68233 8.83567C8.68233 10.4053 7.40967 11.678 5.84 11.678C4.27033 11.678 2.99767 10.4053 2.99767 8.83567C2.99767 7.266 4.27033 5.99333 5.84 5.99333C5.89933 5.99333 5.95733 5.99867 6.01567 6.00233V7.403C5.95733 7.396 5.9 7.38533 5.84 7.38533C5.03867 7.38533 4.38933 8.03467 4.38933 8.836C4.38933 9.63733 5.03867 10.2867 5.84 10.2867C6.64133 10.2867 7.349 9.65533 7.349 8.854C7.349 8.82233 7.363 2.32267 7.363 2.32267H8.70167C8.82767 3.51967 9.794 4.46433 11.002 4.551V6.10767Z"
                />
              </svg>
            </a>
          </div>
          <!-- Hamburger -->
          <div :class="['burger', opened && 'active', 'md:hidden']" @click="toggleMenu">
            <div></div>
          </div>
        </div>
  
        <!-- Mobile panel -->
        <div
          :class="['panel h-[100dvh] md:h-auto pt-2 md:pt-0', opened ? 'opacity-100 block' : 'opacity-0 hidden md:opacity-100 md:block', 'md:flex md:items-center md:gap-8 lg:gap-10']"
        >
          <!-- Menu -->
          <nav class="flex md:inline-flex flex-col md:flex-row font-semibold text-[15px] gap-3 md:gap-7 lg:gap-9 xl:gap-12 tracking-tight">
            <a href="#" class="text-white hover:text-white/70 transition cursor-pointer" @click="setOpened(false)">Inicio</a>
            <a class="text-white hover:text-white/70 transition cursor-pointer" @click="scrollToSection('section-memberships')">Planes</a>
            <a class="text-white hover:text-white/70 transition cursor-pointer" @click="scrollToSection('section-contact')">Ubicación</a>
          </nav>
          <!-- Access button -->
          <a
            :href="`/login`"
            class="font-bold uppercase text-[11px] w-full md:w-auto flex md:inline-flex justify-center items-center py-2.5 md:px-4 text-brand border border-brand rounded-md my-7 cursor-pointer md:my-0 hover:bg-brand hover:text-black transition"
          >
            Acceder →
          </a>
          <!-- Contact info -->
          <div class="flex flex-col gap-6 md:hidden">
            <div class="flex flex-col text-sm tracking-tight">
              <p>
                <span class="text-white/50">Contáctanos</span>
                <br />
                <a :href="`mailto:${sport_center.box_email}`">{{ sport_center.box_email }}</a>
                <br />
                <a v-if="sport_center.box_whatsapp" :href="`https://wa.me/${sport_center.box_whatsapp}?text=hola!`" target="_blank">WhatsApp</a>
              </p>
            </div>
  
            <div v-if="sport_center.box_facebook|| sport_center.box_instagram|| sport_center.box_instagram" class="flex flex-col text-sm tracking-tight">
              <p>
                <span class="text-white/50">Nuestras redes</span>
                <br />
                <a v-if="sport_center.box_facebook" :href="sport_center.box_facebook" target="_blank">Facebook</a>
                <br />
                <a v-if="sport_center.box_instagram" :href="sport_center.box_instagram" target="_blank">Instagram</a>
                <br />
                <a v-if="sport_center.box_instagram" :href="sport_center.box_instagram" target="_blank">TikTok</a>
              </p>
            </div>
  
            <div v-if="sport_center.box_address" class="text-sm tracking-tight">
              <p>
                <span class="text-white/50">Visítanos en</span>
                <br />
                {{ sport_center.box_address }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </header>
  </template>
  
  <script>
  export default {
    props: {
        sport_center: {},
    },
    data() {
      return {
        opened: false,
      };
    },
    methods: {
      toggleMenu() {
        this.opened = !this.opened;
      },
      scrollToSection(id) {
        const element = document.getElementById(id);
        if (element) {
          element.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
          this.opened = false;
        }
      },
      setOpened(value) {
        this.opened = value;
      },
    },
  };
  </script>
  
  <style scoped>
  .header {
    /* Add your CSS styles here */
  }
  .burger {
    cursor: pointer;
  }
  .burger div {
    width: 25px;
    height: 3px;
    background-color: white;
    margin: 6px 0;
  }
  .burger.active div {
    background-color: red;
  }
  .panel {
    transition: opacity 0.3s ease;
  }
  </style>