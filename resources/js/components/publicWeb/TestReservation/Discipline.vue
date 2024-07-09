<!-- <template>
    <div>
      <Listbox v-model="selectedOption" @change="handleSelectedOption">
        <div class="relative">
          <ListboxButton :class="['relative w-full rounded-lg  bg-mid-black py-3 pl-4 pr-10 text-left shadow-md focus:outline-none sm:text-sm border border-white/10']">
            <span class="block truncate text-sm">{{ selectedOption.clase_type }}</span>
            <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
              <ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
            </span>
          </ListboxButton>
          <Transition name="ease-in" mode="out-in">
            <ListboxOptions class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-mid-black py-1 text-base shadow-lg ring-1 ring-black/5 focus:outline-none sm:text-sm">
              <ListboxOption v-for="(discipline, index) in disciplines" :key="index" :value="discipline">
                <span :class="['block truncate text-sm', { 'font-medium': selected, 'font-normal': !selected }]">
                  {{ discipline.clase_type }}
                </span>
                <CheckIcon v-if="selected" class="h-5 w-5" aria-hidden="true" />
              </ListboxOption>
            </ListboxOptions>
          </Transition>
        </div>
      </Listbox>
    </div>
  </template>
  
  <script>
  import { Listbox, ListboxButton, ListboxOptions, ListboxOption } from '@headlessui/vue'
  import { CheckIcon, ChevronUpDownIcon } from '@heroicons/vue/solid'
  
  export default {
    name: 'Discipline',
    components: {
      Listbox,
      ListboxButton,
      ListboxOptions,
      ListboxOption,
      CheckIcon,
      ChevronUpDownIcon
    },
    props: {
      claseTypeName: Array
    },
    data() {
      return {
        selectedOption: {
          id: '0',
          clase_type: "Selecciona una disciplina"
        },
        disciplines: this.claseTypeName
      }
    },
    methods: {
      handleSelectedOption(value) {
        this.selectedOption = value
        this.$emit('activeButton', true)
        this.$emit('updateDiscipline', value)
      }
    }
  }
  </script> -->
  <template>
    <div class="relative">
      <button
        @click="toggleDropdown"
        class="relative w-full rounded-lg bg-mid-black py-3 pl-4 pr-10 text-left shadow-md focus:outline-none sm:text-sm border border-white/10"
      >
        <span class="block truncate text-sm text-white">{{ selectedOption.clase_type }}</span>
        <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
          <svg
            class="h-4 w-4 text-white"
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
      <div v-if="isOpen" class="absolute z-10 mt-1 w-full rounded-md bg-mid-black py-1 text-base shadow-lg ring-1 ring-black/5 focus:outline-none sm:text-sm">
        <ul class="max-h-60 overflow-auto">
          <li
            v-for="(discipline, index) in disciplines"
            :key="index"
            @click="selectOption(discipline)"
            class="cursor-pointer select-none relative py-2 pl-4 pr-4 text-white"
          >
            <span
              :class="['block truncate text-sm', { 'font-medium': selectedOption.id === discipline.id, 'font-normal': selectedOption.id !== discipline.id }]"
            >
              {{ discipline.clase_type }}
            </span>
            <span v-if="selectedOption.id === discipline.id" class="absolute inset-y-0 left-0 flex items-center pl-3">
              <svg
                class="h-5 w-5 "
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
                fill="currentColor"
                aria-hidden="true"
              >
                <path
                  fill-rule="evenodd"
                  d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586l-3.293-3.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z"
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
  name: 'Discipline',
  props: {
    claseTypeName: Array
  },
  data() {

    return {
      selectedOption: {
        id: '0',
        clase_type: 'Selecciona una disciplina'
      },
      disciplines: this.claseTypeName,
      isOpen: false
    };
    
  },
  methods: {
    toggleDropdown() {
      this.isOpen = !this.isOpen;
    },
    selectOption(option) {
      this.selectedOption = option;
      this.isOpen = false;
      this.$emit('activeButton', true);
      this.$emit('updateDiscipline', option);
    }
  }
};
</script>