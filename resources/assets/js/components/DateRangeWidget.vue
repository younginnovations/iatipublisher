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
            style="min-width: 160px"
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
} from 'vue';
import {
  subDays,
  startOfWeek,
  endOfMonth,
  endOfYear,
  startOfMonth,
  startOfYear,
  subMonths,
  startOfDay,
  endOfDay,
  format as dateFormat,
} from 'date-fns';

import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import type { DatePickerInstance } from '@vuepic/vue-datepicker';
import moment from 'moment';

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

const isToday = (start, end) => {
  return (
    dateFormat(startOfDay(new Date()), 'yyyy-MM-dd') ===
      dateFormat(start, 'yyyy-MM-dd') &&
    dateFormat(endOfDay(new Date()), 'yyyy-MM-dd') ===
      dateFormat(end, 'yyyy-MM-dd')
  );
};
const isThisWeek = (start, end) => {
  return (
    dateFormat(startOfWeek(new Date()), 'yyyy-MM-dd') ===
      dateFormat(start, 'yyyy-MM-dd') &&
    dateFormat(end, 'yyyy-MM-dd') ===
      dateFormat(endOfDay(new Date()), 'yyyy-MM-dd')
  );
};
const isLast7Days = (start, end) => {
  return (
    dateFormat(subDays(new Date(), 6), 'yyyy-MM-dd') ===
      dateFormat(start, 'yyyy-MM-dd') &&
    dateFormat(end, 'yyyy-MM-dd') ===
      dateFormat(endOfDay(new Date()), 'yyyy-MM-dd')
  );
};
const isThisMonth = (start, end) => {
  return (
    dateFormat(startOfMonth(new Date()), 'yyyy-MM-dd') ===
      dateFormat(start, 'yyyy-MM-dd') &&
    dateFormat(end, 'yyyy-MM-dd') ==
      dateFormat(endOfMonth(new Date()), 'yyyy-MM-dd')
  );
};
const isLast6Months = (start, end) => {
  return (
    dateFormat(startOfMonth(subMonths(new Date(), 6)), 'yyyy-MM-dd') ===
      dateFormat(start, 'yyyy-MM-dd') &&
    dateFormat(end, 'yyyy-MM-dd') ===
      dateFormat(endOfMonth(new Date()), 'yyyy-MM-dd')
  );
};
const isThisYear = (start, end) => {
  return (
    dateFormat(startOfYear(new Date()), 'yyyy-MM-dd') ===
      dateFormat(start, 'yyyy-MM-dd') &&
    dateFormat(end, 'yyyy-MM-dd') ===
      dateFormat(endOfDay(new Date()), 'yyyy-MM-dd')
  );
};
const isLast12Months = (start, end) => {
  return (
    dateFormat(startOfMonth(subMonths(new Date(), 12)), 'yyyy-MM-dd') ===
      dateFormat(start, 'yyyy-MM-dd') &&
    dateFormat(end, 'yyyy-MM-dd') ===
      dateFormat(endOfDay(new Date()), 'yyyy-MM-dd')
  );
};
const isAllTime = (start, end) => {
  return (
    dateFormat(new Date('1990-12-31'), 'yyyy-MM-dd') ===
      dateFormat(start, 'yyyy-MM-dd') &&
    dateFormat(end, 'yyyy-MM-dd') ===
      dateFormat(endOfDay(new Date()), 'yyyy-MM-dd')
  );
};

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
      resolveStartDateAndEndDate(selectedDate.value[0], selectedDate.value[1]);
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

const resolveStartDateAndEndDate = (startDate, endDate) => {
  if (isToday(startDate, endDate)) {
    fixed.value = 'Today';
  } else if (isThisWeek(startDate, endDate)) {
    fixed.value = 'This week';
  } else if (isLast7Days(startDate, endDate)) {
    fixed.value = 'Last 7 days';
  } else if (isThisMonth(startDate, endDate)) {
    fixed.value = 'This month';
  } else if (isLast6Months(startDate, endDate)) {
    fixed.value = 'Last 6 month';
  } else if (isThisYear(startDate, endDate)) {
    fixed.value = 'This year (Jan 1 - Today)';
  } else if (isLast12Months(startDate, endDate)) {
    fixed.value = 'Last 12 months';
  } else if (isAllTime(startDate, endDate)) {
    fixed.value = 'All time';
  } else {
    fixed.value = 'Custom';
  }
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

<style lang="scss" scoped>
.daterange-item {
  padding: 8px;
  border-radius: 4px;
  margin-top: 2px;
  margin-bottom: 2px;
}

.daterange-item:hover {
  @apply bg-spring-20;
  cursor: pointer;
  color: white;
}
.daterange-item-active {
  @apply bg-spring-20;
  color: white;
}
</style>
