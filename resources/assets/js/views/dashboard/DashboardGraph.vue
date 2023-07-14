<template>
  <div class="chart-wrapper h-[280px]">
    <div v-if="showGraphLoader" class="mx-auto mt-20 h-[100px] w-[100px]">
      <spinnerLoader class="!h-[100px] !w-[100px]" />
    </div>

    <apexchart
      id="chart"
      ref="chart"
      type="line"
      :class="{ 'opacity-0': showGraphLoader }"
      :options="chartOptions"
      :series="series"
    />
  </div>
</template>

<script setup lang="ts">
import moment from 'moment';
import spinnerLoader from 'Components/spinnerLoader.vue';
import { reactive, ref, inject, Ref, watch, computed, defineProps } from 'vue';

interface yAxisInterface {
  result: number[];
}

interface ChartInterface {
  chart?: { w: { globals: { yAxisScale: yAxisInterface[] } } };
}

const labels = ref<number[]>([]);
const roundedLabels = ref<number[]>([]);
const showGraphLoader = inject('showGraphLoader') as Ref;

const graphAmount = inject('graphAmount') as Ref;
const yaxisTicks = ref([]);
const maxValue = ref(0);
const chart = ref<ChartInterface>({});
const graphColor = '#17997B';
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
    height: '100%', // Set the height to 100% to cover the full space

    type: 'line',
    offsetY: 5,
    zoom: {
      enabled: false,
    },
    options: {
      xaxis: {
        labels: {
          padding: {
            left: 50, // Adjust the left padding value as needed
          },
        },
      },
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

  colors: [graphColor],
  tooltip: {
    custom: function ({ series, seriesIndex, dataPointIndex, w }) {
      const getDay = (formattedDate) => {
        return moment(formattedDate).format('ddd MMM DD YYYY');
      };
      return `<div class="p-4">
                <div class="text-n-40"> ${getDay(
                  w.globals.categoryLabels[dataPointIndex]
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
    padding: {
      left: 100, // Increase the space between the left edge of the chart and the first tick
      right: 20, // Increase the space between the last tick and the right edge of the chart
    },
    labels: {
      rotate: 0,
    },
  },

  yaxis: {
    min: 0, // minimum value on the y-axis
    max: maxValue.value + 3, // maximum value on the y-axis
    tickAmount: maxValue.value > 4 ? 5 : maxValue.value + 3, // number of ticks to display on the y-axis

    // Additional spacing options
    offsetY: 10, // Increase the spacing between the y-axis line and the tick labels

    labels: {
      offsetY: 10, // Increase the spacing between the tick labels and the plot area

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
