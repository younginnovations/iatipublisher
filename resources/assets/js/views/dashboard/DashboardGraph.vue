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
import { reactive, ref } from 'vue';
const xAxisCounter = ref(0);

let chartOptions = reactive({
  chart: {
    height: 210,
    type: 'line',
    zoom: {
      enabled: false,
    },
  },
  stroke: {
    width: 1,
  },
  colors: ['#17997B'],
  tooltip: {
    custom: function ({ series, seriesIndex, dataPointIndex, w, xaxis }) {
      return `<div class="p-4">
                <div> ${xaxis}</div>
                <div>${series[seriesIndex][dataPointIndex]}</div>
              </div>`;
    },
  },
  xaxis: {
    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],

    labels: {
      formatter: function (value) {
        xAxisCounter.value++;
        if (
          xAxisCounter.value === 26 ||
          xAxisCounter.value === Math.trunc(4 + 26 * 0.33) ||
          xAxisCounter.value === 4
        ) {
          return value + xAxisCounter.value;
        } else return value;
      },
    },
  },
});

const series = reactive([
  {
    name: 'Desktops',
    data: [10, 41, 35, 51, 49, 62, 69, 91, 148],
  },
]);
</script>
