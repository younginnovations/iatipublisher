<template>
  <div class="chart-wrapper">
    <apexchart
      height="210"
      type="line"
      :options="chartOptions"
      :series="series"
    >
    </apexchart>
  </div>
</template>

<script setup lang="ts">
import moment from 'moment';

import dateFormat from 'Composable/dateFormat';
import {
  reactive,
  ref,
  inject,
  Ref,
  onUpdated,
  watch,
  computed,
  defineProps,
} from 'vue';
const xAxisCounter = ref(0);
const graphDate = inject('graphDate') as Ref;
const graphAmount = inject('graphAmount') as Ref;
const xAxisData = ref([]);
const props = defineProps({
  currentView: {
    type: String,
    required: true,
  },
});

const tooltipText = computed(() => {
  switch (props.currentView) {
    case 'publisher':
      return 'Total no. of publisher registration';
    case 'activity':
      return 'Total no. of activities added';

    default:
      return 'Total number of user';
  }
});
let chartOptions = computed(() => ({
  chart: {
    height: 210,
    type: 'line',
    zoom: {
      enabled: false,
    },
    toolbar: {
      show: false,
    },
  },
  stroke: {
    curve: 'straight',
    width: 1,
  },
  colors: ['#17997B'],
  tooltip: {
    custom: function ({ series, seriesIndex, dataPointIndex, w }) {
      console.log(
        'from graph',

        w.globals.categoryLabels[seriesIndex]
      );
      const monthReverter = (month) => {
        switch (month) {
          case 'Jan':
            return '01';

          case 'Feb':
            return '02';
          case 'Mar':
            return '03';
          case 'Apr':
            return '04';
          case 'May':
            return '05';
          case 'June':
            return '06';
          case 'July':
            return '07';
          case 'Aug':
            return '08';
          case 'Sep':
            return '09';
          case 'Oct':
            return '10';
          case 'Nov':
            return '11';
          case 'Dec':
            return '12';
          default:
            break;
        }
      };
      const getDay = (formattedDaye) => {
        let orginal = new Date(`${formattedDaye.split(' ')[2]}-${monthReverter(
          formattedDaye.split(' ')[0]
        )}-${formattedDaye.split(' ')[1]}
        `);
        console.log(orginal);

        return `${orginal.toString().split(' ')[0]} ${
          orginal.toString().split(' ')[1]
        } ${orginal.toString().split(' ')[2]}`;
      };

      return `<div class="p-4">
                <div class="text-n-40"> ${getDay(
                  w.globals.categoryLabels[seriesIndex]
                )}</div>
                <div class="flex text-n-50 space-x-4 justify-between"><div>${
                  tooltipText.value
                }</div>
                <div class="font-bold">${
                  series[seriesIndex][dataPointIndex]
                }</div></div>
              </div>`;
    },
  },

  xaxis: {
    tickAmount: 3,
    labels: {
      rotate: 0,
    },
  },
}));

// let chartOptions = reactive({
//   chart: {
//     height: 210,
//     type: 'line',
//     zoom: {
//       enabled: false,
//     },
//   },
//   stroke: {
//     curve: 'straight',
//     width: 1,
//   },
//   colors: ['#17997B'],
//   tooltip: {
//     custom: function ({ series, seriesIndex, dataPointIndex, w, xaxis }) {
//       return `<div class="p-4">
//                 <div> ${xaxis}</div>
//                 <div>${series[seriesIndex][dataPointIndex]}</div>
//               </div>`;
//     },
//   },

//   xaxis: {
//     tickAmount: 3,
//   },
// });

let series = reactive([
  {
    name: 'Desktops',
    type: 'line',
    data: graphAmount.value,
  },
]);
watch(
  () => graphAmount.value,
  () => {
    series['data'] = graphAmount.value;
  },
  { deep: true }
);
</script>
