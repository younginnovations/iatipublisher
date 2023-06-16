<template>
  <div id="date-range-main" class="flex space-x-2">
    <div>
      <div class="relative" style="min-width: 150px">
        <!--Range Dropdown-->
        <div
          v-if="dropdownRange && Object.keys(dropdownRange).length"
          class="flex hover:cursor-pointer"
          @click="toggleShowRangeDropdown"
        >
          <span>{{ dateType }}</span>
          <span style="height: fit-content; font-size: 20px; margin-top: 2px">
            <svg-vue icon="arrow-down"></svg-vue>
          </span>
        </div>
        <ul
          v-show="showRangeDropdown"
          class="absolute w-fit bg-white p-2 shadow-sm"
          style="top: 32px; right: 8px"
        >
          <li
            v-for="(value, key) in dropdownRange"
            :key="key"
            class="daterange-item"
            :class="value === dateType ? 'daterange-item-active' : ''"
            @click="
              () => {
                dateType = value;
                dateTypeKey = key;
              }
            "
            style="min-width: 160px"
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
        class="w-fit bg-n-10 py-1 px-2 text-center text-xs font-semibold text-bluecoral hover:cursor-pointer"
        style="border-radius: 4px"
        @click="openCalendar"
        >{{ fixed }}</span
      >
    </div>
    <div class="">
      <div class="relative flex">
        <VueDatePicker
          ref="datepicker"
          v-model="selectedDate"
          range
          :preset-ranges="presetRanges"
          :enable-time-picker="false"
          right
          month-name-format="long"
          :format="format"
          placeholder="Select date"
          :clearable="true"
          mode-height="650"
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
          class="absolute top-1/2 right-0 -translate-y-1/2"
          style="height: fit-content; font-size: 20px; margin-top: 2px"
        >
          <svg-vue icon="arrow-down"></svg-vue>
        </span>
      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { ref, watch, defineEmits, Ref, defineProps, onMounted } from 'vue';
import {
  subDays,
  startOfWeek,
  endOfMonth,
  endOfYear,
  startOfMonth,
  startOfYear,
  subMonths,
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
  dateLabel: {
    type: String,
    required: false,
    default: '',
  },
});

const dateType = ref('');
dateType.value = props.dropdownRange && Object.values(props.dropdownRange)[0];

const dateTypeKey = ref('');
dateTypeKey.value = props.dropdownRange && Object.keys(props.dropdownRange)[0];

const showRangeDropdown = ref(false);

const toggleShowRangeDropdown = () => {
  showRangeDropdown.value = !showRangeDropdown.value;
};

const emit = defineEmits(['triggerSetDateRange', 'triggerSetDateType']);

const fixed: Ref<string> = ref('All time');

const selectedDate: Ref<any[]> = ref([
  new Date(),
  new Date(new Date().setDate(new Date().getDate() + 7)),
]);

const presetRanges = ref([
  {
    label: 'Today',
    range: [new Date(), new Date()],
  },
  {
    label: 'This week',
    range: [startOfWeek(new Date()), new Date()],
  },
  {
    label: 'Last 7 days',
    range: [subDays(new Date(), 6), new Date()],
  },
  {
    label: 'This month',
    range: [startOfMonth(new Date()), endOfMonth(new Date())],
  },
  {
    label: 'Last 6 months',
    range: [startOfMonth(subMonths(new Date(), 6)), new Date()],
  },
  {
    label: 'This year',
    range: [startOfYear(new Date()), endOfYear(new Date())],
  },
  {
    label: 'Last 12 months',
    range: [startOfMonth(subMonths(new Date(), 12)), new Date()],
  },
  {
    label: 'All time',
    range: [new Date('1990-12-31'), new Date()],
  },
]);
onMounted(() => {
  selectedDate.value[0] = '1990-12-31';
  selectedDate.value[1] = moment(new Date()).format('YYYY-MM-DD');

  // triggerSetDateRange('1990-12-31', moment(new Date()).format('YYYY-MM-DD'));
  triggerSetDateRange('1990-12-31', '2020-12-31');
});

const datepicker = ref<DatePickerInstance>(null);

const convertDate = (date) => {
  const dateObj = new Date(date);
  const year = dateObj.getFullYear();
  const month = String(dateObj.getMonth() + 1).padStart(2, '0');
  const day = String(dateObj.getDate()).padStart(2, '0');
  return `${year}-${month}-${day}`;
};

const clearDate = () => {
  triggerSetDateRange('', '');
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
  var tempArray: any = [];

  for (let i = 0; i < dates.length; i++) {
    tempArray[i] = dates[i].toLocaleDateString('en-US', {
      month: 'short',
      day: 'numeric',
      year: 'numeric',
    });
  }

  return tempArray.join(' - ');
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
      triggerSetDateRange(startDate, endDate);
      resolveStartDateAndEndDate(moment(startDate), moment(endDate));
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

const triggerSetDateRange = (startDate, endDate) => {
  emit('triggerSetDateRange', startDate, endDate);
};

const triggerSetDateType = (eventType) => {
  emit('triggerSetDateType', eventType);
};

const resolveStartDateAndEndDate = (startDate, endDate) => {
  const currentDate = moment(convertDate(new Date()));
  let fixedValue;

  if (checkIfToday(startDate.clone(), currentDate.clone(), endDate.clone())) {
    fixedValue = 'Today';
  } else if (
    checkIfThisWeek(startDate.clone(), currentDate.clone(), endDate.clone())
  ) {
    fixedValue = 'This week';
  } else if (
    checkIfLast7Days(startDate.clone(), currentDate.clone(), endDate.clone())
  ) {
    fixedValue = 'Last 7 days';
  } else if (
    checkIfThisMonth(startDate.clone(), currentDate.clone(), endDate.clone())
  ) {
    fixedValue = 'This Month';
  } else if (checkIfLast6Months(startDate.clone(), currentDate.clone())) {
    fixedValue = 'Last 6 months';
  } else if (
    checkIfThisYear(startDate.clone(), currentDate.clone(), endDate.clone())
  ) {
    fixedValue = 'This year';
  } else if (checkIfLast12Months(startDate.clone(), currentDate.clone())) {
    fixedValue = 'Last 12 months';
  } else if (
    checkIfAllTime(startDate.clone(), currentDate.clone(), endDate.clone())
  ) {
    fixedValue = 'All Time';
  } else {
    fixedValue = 'Custom';
  }

  fixed.value = fixedValue;
};

const checkIfToday = (start, current, end) => {
  if (start.format('YYYY-MM-DD') == end.format('YYYY-MM-DD')) {
    return (
      start.format('YYYY-MM-DD') == current.format('YYYY-MM-DD') &&
      end.format('YYYY-MM-DD') == current.format('YYYY-MM-DD')
    );
  }

  return false;
};
const checkIfThisWeek = (start, current, end) => {
  const currentWeekStart = current.startOf('week').format('YYYY-MM-DD');
  const currentWeekEnd = current.endOf('week').format('YYYY-MM-DD');

  return (
    currentWeekStart <= start.format('YYYY-MM-DD') &&
    currentWeekEnd >= end.format('YYYY-MM-DD')
  );
};
const checkIfLast7Days = (start, current, end) => {
  const sixDaysBefore = current
    .clone()
    .subtract(6, 'days')
    .format('YYYY-MM-DD');

  return (
    current.format('YYYY-MM-DD') == end.format('YYYY-MM-DD') &&
    start.format('YYYY-MM-DD') == sixDaysBefore
  );
};
const checkIfThisMonth = (start, current, end) => {
  const currentMonthStart = current.startOf('month').format('YYYY-MM-DD');
  const currentMonthEnd = current.endOf('month').format('YYYY-MM-DD');

  return (
    currentMonthStart <= start.format('YYYY-MM-DD') &&
    currentMonthEnd >= end.format('YYYY-MM-DD')
  );
};
const checkIfLast6Months = (start, current) => {
  const sixMonthBefore = current
    .clone()
    .subtract(6, 'months')
    .startOf('month')
    .format('YYYY-MM-DD');

  return sixMonthBefore == start.format('YYYY-MM-DD');
};
const checkIfThisYear = (start, current, end) => {
  const currentYearStart = current.startOf('year').format('YYYY-MM-DD');
  const currentYearEnd = current.endOf('year').format('YYYY-MM-DD');

  return (
    currentYearStart === start.format('YYYY-MM-DD') &&
    currentYearEnd === end.format('YYYY-MM-DD')
  );
};
const checkIfLast12Months = (start, current) => {
  const startDate = current
    .clone()
    .subtract(12, 'months')
    .startOf('month')
    .format('YYYY-MM-DD');

  return startDate === start.format('YYYY-MM-DD');
};
const checkIfAllTime = (start, current, end) => {
  return (
    start.format('YYYY-MM-DD') == '1990-12-31' &&
    end.format('YYYY-MM-DD') == current.format('YYYY-MM-DD')
  );
};
</script>

<style lang="scss" scoped>
.border {
  border: 1px solid red;
}

.daterange-item {
  padding: 8px;
  border-radius: 4px;
  margin-top: 2px;
  margin-bottom: 2px;
}

.daterange-item:hover {
  @apply bg-spring-10;
  cursor: pointer;
  color: white;
}
.daterange-item-active {
  @apply bg-spring-10;
  color: white;
}
</style>
