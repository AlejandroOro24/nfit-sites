<template>
  <div class="relative">
    <button
      @click="toggleDropdown"
      :class="['relative w-full rounded-lg bg-midBlack py-3 pl-4 pr-10 text-left shadow-md focus:outline-none sm:text-sm border border-white/10', { 'text-white/50 cursor-default': !actived, 'text-white cursor-pointer': actived }]"
      :disabled="!actived"
    >
      <span class="block truncate text-sm">{{ selected }}</span>
      <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
        <svg
          class="h-5 w-5 text-gray-400"
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 20 20"
          fill="currentColor"
          aria-hidden="true"
        >
          <path
            fill-rule="evenodd"
            d="M10 3a1 1 0 01.7.3l5 5a1 1 0 01-1.4 1.4L10 5.4 5.7 9.7a1 1 0 01-1.4-1.4l5-5A1 1 0 0110 3z"
            clip-rule="evenodd"
          />
        </svg>
      </span>
    </button>
      <div v-if="isOpen && !isDisabled" class="absolute z-10 mt-1 w-full rounded-md bg-mid-black py-1 text-base text-white shadow-lg ring-1 ring-black/5 focus:outline-none sm:text-sm">
        <ul class="max-h-60 overflow-auto bg-midBlack">
          <li
            v-for="(time, index) in times"
            :key="index"
            @click="selectOption(time)"
            class="cursor-pointer select-none relative py-2 pl-4 pr-4"
          >
            <span :class="['block truncate text-sm', { 'font-medium': selected === time, 'font-normal': selected !== time }]">
              {{ time }}
            </span>
            <span v-if="selected === time" class="absolute inset-y-0 left-0 flex items-center pl-3">
              <svg
                class="h-5 w-5"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
                fill="currentColor"
                aria-hidden="true"
              >
                <path
                  fill-rule="evenodd"
                  d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586l-3.293-3.293a1 1 0 00-1.4 1.4l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z"
                  clip-rule="evenodd"
                />
              </svg>
            </span>
          </li>
        </ul>
      </div>
  </div>
</template>

<script>
export default {
  name: 'TimeSelector',
  props: {
    actived: Boolean,
    activeDiscipline: Function,
    updateTime: Function,
    schedules: {
      type: Array,
      required: true,
      default: () => []
    }
  },
  data() {
    return {
      selected: 'Selecciona un horario',
      times: this.schedules || [],
      isDisabled: !this.schedules || this.schedules.length === 0,
      isOpen: false
    };
  },
  watch: {
    schedules(newTimes) {
      this.times = newTimes || [];
      this.isDisabled = !newTimes || newTimes.length === 0;
    }
  },
  methods: {
    toggleDropdown() {
      if (!this.isDisabled) {
        this.isOpen = !this.isOpen;
      }
    },
    selectOption(time) {
      this.selected = time;
      this.isOpen = false;
      this.$emit('activeDiscipline', true);
      this.$emit('updateTime', time);
    }
  }
};
</script>