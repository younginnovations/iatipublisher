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
import dateFormat from 'Composable/dateFormat';
import { reactive, ref, inject, Ref, onUpdated, watch, computed } from 'vue';
const xAxisCounter = ref(0);
const graphDate = inject('graphDate') as Ref;
const graphAmount = inject('graphAmount') as Ref;
const xAxisData = ref([]);

let chartOptions = computed(() => ({
  chart: {
    height: 210,
    type: 'line',
    zoom: {
      enabled: false,
    },
  },
  stroke: {
    curve: 'straight',
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
    tickAmount: 3,
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
