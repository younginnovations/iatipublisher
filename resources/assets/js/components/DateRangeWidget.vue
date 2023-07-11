<template>
  <div id="date-range-main" ref="dateRangeMain" class="flex space-x-1">
    <div>
      <div class="relative min-w-[150px]">
        <!--Range Dropdown-->
        <div
          v-if="dropdownRange && Object.keys(dropdownRange).length"
          class="flex hover:cursor-pointer"
          @click="toggleShowRangeDropdown"
        >
          <span>{{ dateType }} </span>
          <span style="height: fit-content; font-size: 20px; margin-top: 2px">
            <svg-vue icon="arrow-down"></svg-vue>
          </span>
        </div>
        <ul
          v-show="showRangeDropdown"
          ref="dateDropdown"
          class="absolute w-fit bg-white p-2 shadow-sm"
          style="top: 32px; right: 8px"
        >
          <li
            v-for="(value, key) in dropdownRange"
            :key="key"
            class="daterange-item"
            :class="value === dateType ? 'daterange-item-active' : ''"
            style="min-width: 180px"
            @click="
              () => {
                showRangeDropdown = false;
                dateType = value;
                dateTypeKey = key;
              }
            "
          >
            {{ value }}
          </li>
        </ul>
      </div>
    </div>

    <div class="h-fit w-fit">
      <span v-if="dateLabel" class="mx-2 text-sm text-n-50">{{
        dateLabel
      }}</span>

      <span
        id="fixed-date-range"
        class="w-fit rounded bg-n-10 py-1 px-2 text-center text-xs text-bluecoral hover:cursor-pointer"
        @click="openCalendar"
        >{{ fixed }}
      </span>
    </div>
    <div class="">
      <div
        :class="{ empty: !selectedDate[0], 'all-time': fixed === 'All time ' }"
        class="relative flex"
      >
        <VueDatePicker
          ref="datepicker"
          v-model="selectedDate"
          range
          month-name-format="long"
          placeholder="Select date"
          mode-height="650"
          :clearable="true"
          :format="format"
          :preset-ranges="presetRanges"
          :enable-time-picker="false"
          :teleport="true"
          :alt-position="customPosition"
          @open="addEventsForCalendar"
          @cleared="clearDate"
        >
          <template #yearly="{ label, range, presetDateRange }">
            <span @click="presetDateRange(range)">
              {{ label }}
            </span>
          </template>

          <template #action-buttons>
            <div class="flex">
              <button
                class="font-neutral mx-2 w-fit p-2 font-bold uppercase"
                @click="closeCalendar"
              >
                Cancel
              </button>
              <button
                class="font-spring mx-2 w-fit p-2 font-bold uppercase"
                @click="selectDate"
              >
                Apply
              </button>
            </div>
          </template>
        </VueDatePicker>

        <span
          class="absolute top-1/2 right-0 -translate-y-1/2 cursor-pointer"
          style="height: fit-content; font-size: 20px; margin-top: 2px"
          @click="openCalendar"
        >
          <svg-vue icon="arrow-down"></svg-vue>
        </span>
      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>
import {
  ref,
  watch,
  defineEmits,
  Ref,
  defineProps,
  onMounted,
  computed,
  inject,
} from 'vue';
import {
  subDays,
  startOfWeek,
  endOfMonth,
  startOfMonth,
  startOfYear,
  subMonths,
  startOfDay,
  endOfDay,
} from 'date-fns';

import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import type { DatePickerInstance } from '@vuepic/vue-datepicker';
import moment from 'moment';

const selectedPresentIndex = ref(99);

const handlePresentRangeItemClick = (index) => {
  const presentRangeItems = document.getElementsByClassName('dp__preset_range');
  selectedPresentIndex.value = index;
  presentRangeItems[index].classList.add('preset-range-item-active');

  for (let j = 0; j < presentRangeItems.length; j++) {
    if (j !== index) {
      presentRangeItems[j].classList.remove('preset-range-item-active');
    }
  }
};

const handleCalendarItemClick = () => {
  selectedPresentIndex.value = 99;
};

const addEventsForCalendar = () => {
  const presentRangeItems = document.getElementsByClassName('dp__preset_range');

  for (let i = 0; i < presentRangeItems.length; i++) {
    presentRangeItems[i].addEventListener('click', () => {
      handlePresentRangeItemClick(i);
    });
  }

  const calendarItems = document.getElementsByClassName('dp__calendar_item');

  for (let i = 0; i < calendarItems.length; i++) {
    calendarItems[i].addEventListener('click', handleCalendarItemClick);
  }
};

const removeEventsOfCalendar = () => {
  const presentRangeItems = document.getElementsByClassName('dp__preset_range');

  for (let i = 0; i < presentRangeItems.length; i++) {
    presentRangeItems[i].removeEventListener('click', () => {
      handlePresentRangeItemClick(i);
    });
  }

  const calendarItems = document.getElementsByClassName('dp__calendar_item');

  for (let i = 0; i < calendarItems.length; i++) {
    calendarItems[i].removeEventListener('click', handleCalendarItemClick);
  }
};

const props = defineProps({
  dropdownRange: {
    type: Object,
    required: false,
    default: () => ({}),
  },
  firstDate: {
    type: String,
    required: true,
  },
  dateLabel: {
    type: String,
    required: false,
    default: '',
  },
});
const currentView = inject('currentView') as Ref;

const dateRangeMain: Ref<Element | null> = ref(null);
const dateType = ref('');
const dateDropdown = ref();
dateType.value = props.dropdownRange && Object.values(props.dropdownRange)[0];

const dateTypeKey = ref('');
dateTypeKey.value = props.dropdownRange && Object.keys(props.dropdownRange)[0];

const showRangeDropdown = ref(false);

const toggleShowRangeDropdown = () => {
  showRangeDropdown.value = !showRangeDropdown.value;
};

const emit = defineEmits(['triggerSetDateRange', 'triggerSetDateType']);
const initialDate = computed(() => props.firstDate);

const fixed = ref('All time');
const todayDate = moment(new Date()).format('YYYY-MM-DD');
const selectedDate: Ref<Date[] | string[]> = ref([
  new Date(),
  new Date(new Date().setDate(new Date().getDate() + 7)),
]);

const clearDate = () => {
  triggerSetDateRange('', '');
  selectedDate.value[0] = '';
  selectedDate.value[1] = '';
};

const presetRanges = computed(() => [
  {
    label: 'Today',
    range: [startOfDay(new Date()), endOfDay(new Date())],
  },
  {
    label: 'This week',
    range: [startOfWeek(new Date()), endOfDay(new Date())],
  },
  {
    label: 'Last 7 days',
    range: [subDays(new Date(), 6), endOfDay(new Date())],
  },
  {
    label: 'This month',
    range: [startOfMonth(new Date()), endOfMonth(new Date())],
  },
  {
    label: 'Last 6 month',
    range: [startOfMonth(subMonths(new Date(), 6)), endOfMonth(new Date())],
  },
  {
    label: 'This year',
    range: [startOfYear(new Date()), endOfDay(new Date())],
  },
  {
    label: 'Last 12 months',
    range: [startOfMonth(subMonths(new Date(), 12)), endOfDay(new Date())],
  },
  {
    label: 'All time',
    range: [new Date(initialDate.value), endOfDay(new Date())],
  },
]);

onMounted(() => {
  selectedDate.value[0] = '';
  selectedDate.value[1] = todayDate;
  triggerSetDateRange('', todayDate, fixed.value);
});

const datepicker = ref<DatePickerInstance>(null);

const convertDate = (date) => {
  const dateObj = new Date(date);
  const year = dateObj.getFullYear();
  const month = String(dateObj.getMonth() + 1).padStart(2, '0');
  const day = String(dateObj.getDate()).padStart(2, '0');
  return `${year}-${month}-${day}`;
};

const openCalendar = () => {
  if (datepicker.value) {
    datepicker.value.openMenu();
  }
};

const closeCalendar = () => {
  if (datepicker.value) {
    removeEventsOfCalendar();
    clearDate();

    datepicker.value.closeMenu();
  }
};

const selectDate = () => {
  if (datepicker.value) {
    datepicker.value.selectDate();
  }
};

const format = (dates) => {
  const tempArray: string | number[] = [];

  for (let i = 0; i < dates.length; i++) {
    tempArray[i] = dates[i].toLocaleDateString('en-US', {
      month: 'short',
      day: 'numeric',
      year: 'numeric',
    });
  }

  return tempArray.join(' - ');
};

const closeDateDropdown = () => {
  showRangeDropdown.value = false;
};

watch(
  () => showRangeDropdown.value,
  (value) => {
    if (value) {
      document.addEventListener('click', closeDateDropdown);
      dateRangeMain.value?.addEventListener('click', keepModelOpen);
    } else {
      document.removeEventListener('click', closeDateDropdown);
      dateRangeMain.value?.removeEventListener('click', keepModelOpen);
    }
  }
);
const keepModelOpen = (event) => {
  event.stopPropagation();
};

watch(
  () => [selectedDate],
  () => {
    const startDate =
      selectedDate.value && selectedDate.value[0]
        ? convertDate(selectedDate.value[0])
        : false;
    const endDate =
      selectedDate.value && selectedDate.value[1]
        ? convertDate(selectedDate.value[1])
        : false;

    if (startDate && endDate) {
      triggerSetDateRange(startDate, endDate, fixed.value);
      setSelectedPresentDayText();
    }
  },
  { deep: true }
);

watch(
  () => [dateType],
  () => {
    triggerSetDateType(dateTypeKey.value);
  },
  { deep: true }
);

const triggerSetDateRange = (startDate, endDate, filteredDateType = '') => {
  emit('triggerSetDateRange', startDate, endDate, filteredDateType);
};

// watch(
//   () => currentView?.value,
//   () => {
//     clearDate();
//     console.log('changed');
//   }
// );

watch(
  () => fixed.value,
  () => {
    const startDate =
      selectedDate.value && selectedDate.value[0]
        ? convertDate(selectedDate.value[0])
        : false;
    const endDate =
      selectedDate.value && selectedDate.value[1]
        ? convertDate(selectedDate.value[1])
        : false;

    if (startDate && endDate) {
      triggerSetDateRange(startDate, endDate, fixed.value);
    }
  }
);

const triggerSetDateType = (eventType) => {
  emit('triggerSetDateType', eventType);
};

const setSelectedPresentDayText = () => {
  fixed.value =
    presetRanges.value[selectedPresentIndex.value]?.label ?? 'Custom';
  selectedPresentIndex.value = 99;
};

const customPosition = () => {
  return {
    top: Number(dateRangeMain.value?.getBoundingClientRect().bottom) + 20,
    left: dateRangeMain.value
      ? Number(dateRangeMain.value?.getBoundingClientRect().left) +
        (window.innerWidth -
          dateRangeMain.value?.getBoundingClientRect()?.right >
        150
          ? 140
          : -90)
      : 0,
  };
};
</script>
