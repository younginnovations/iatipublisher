<template>
  <div class="chart-wrapper">
    <apexchart
      id="chart"
      ref="chart"
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

interface yAxisInterface {
  result: number[];
}

interface ChartInterface {
  chart?: { w: { globals: { yAxisScale: yAxisInterface[] } } };
}

const xAxisCounter = ref(0);
const labels = ref<number[]>([]);
const roundedLabels = ref<number[]>([]);
const graphDate = inject('graphDate') as Ref;
const graphAmount = inject('graphAmount') as Ref;
const xAxisData = ref([]);
const yaxisTicks = ref([]);
const maxValue = ref(0);
const chart = ref<ChartInterface>({});
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
    offsetY: 5,
    zoom: {
      enabled: false,
    },
    toolbar: {
      show: false,
    },
  },
  markers: {
    size: graphAmount.value.length > 1 ? 0 : 2, // Customize the marker size
    strokeWidth: 0, // Remove the stroke around the marker
    colors: ['#17997B'], // Customize the marker color
    hover: {
      size: 6, // Customize the marker size on hover
    },
  },
  stroke: {
    curve: 'straight',
    width: 1,
  },

  colors: ['#17997B'],
  tooltip: {
    custom: function ({ series, seriesIndex, dataPointIndex, w }) {
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

  yaxis: {
    min: 0, // minimum value on the y-axis
    max: maxValue.value + 4, // maximum value on the y-axis
    tickAmount: maxValue.value > 4 ? 6 : maxValue.value + 5, // number of ticks to display on the y-axis
    labels: {
      formatter: function (value, index) {
        labels.value =
          chart.value &&
          (chart.value?.chart?.w.globals.yAxisScale[0].result as number[]);

        roundedLabels.value = [];
        for (let count = 0; count < labels.value.length; count++) {
          if (!roundedLabels.value.includes(Math.round(labels.value[count]))) {
            roundedLabels.value.push(Math.round(labels.value[count]));
          }
        }
        return roundedLabels.value[index];
      },
    },
  },
}));

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
    maxValue.value = 0;
    yaxisTicks.value.length = 0;
    for (let i = 0; i < graphAmount.value.length; i++) {
      if (maxValue.value < graphAmount.value[i]['y']) {
        maxValue.value = graphAmount.value[i]['y'];
      }
    }

    series['data'] = graphAmount.value;
  },
  { deep: true }
);
</script>
