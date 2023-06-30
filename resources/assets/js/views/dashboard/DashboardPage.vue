<template>
  <div class="mx-auto w-screen max-w-[1400px] py-8 px-6">
    <div class="mb-3 flex flex-wrap justify-between border-b border-n-20 pb-3">
      <div class="flex gap-x-2">
        <button
          :class="
            currentView === 'publisher'
              ? ' !border-turquoise bg-n-10 text-bluecoral'
              : ''
          "
          class="flex w-[140px] justify-center rounded border border-n-20 py-2 text-sm text-n-40"
          @click="currentView = 'publisher'"
        >
          <span> Publisher</span>
        </button>
        <button
          :class="
            currentView === 'activity'
              ? ' !border-turquoise bg-n-10 text-bluecoral'
              : ''
          "
          class="flex w-[140px] justify-center rounded border border-n-20 py-2 text-sm text-n-40"
          @click="currentView = 'activity'"
        >
          <span>Activity</span>
        </button>
        <button
          :class="
            currentView === 'user'
              ? ' !border-turquoise bg-n-10 text-bluecoral'
              : ''
          "
          class="flex w-[140px] justify-center rounded border border-n-20 py-2 text-sm text-n-40"
          @click="currentView = 'user'"
        >
          <span>Users</span>
        </button>
      </div>
      <div class="flex w-full items-center justify-end space-x-2 xl:w-auto">
        <DateRangeWidget
          :date-label="DateLabel"
          @trigger-set-date-range="setDateRangeDate"
        />
        <ButtonComponent
          text="Download report"
          type="secondary"
          icon="download-file"
          @click="downloadReport"
        />
      </div>
    </div>

    <DashboardStatsSection :current-view="currentView" />
    <DashboardListSection
      :current-view="currentView"
      :table-data="tableData"
      :table-header="currentNav['label']"
      @table-nav="(n, filter, page) => handleChangeTableNav(n, filter, page)"
    />
  </div>
</template>

<script setup lang="ts">
import DashboardStatsSection from './DashboardStatsSection.vue';
import DashboardListSection from './DashboardListSection.vue';
import DateRangeWidget from 'Components/DateRangeWidget.vue';
import { ref, onMounted, provide, watch } from 'vue';
import ButtonComponent from 'Components/ButtonComponent.vue';
import axios from 'axios';
import moment from 'moment';

const currentNav = ref({
  label: 'Publisher Type',
  apiParams: 'publisher-type',
});
const tableData = ref<any>([]);
const DateLabel = ref('Registered date:');
const startDate = ref('');
const endDate = ref('');
const graphAmount = ref<object[]>([]);
const graphTotal = ref(0);
const showTableLoader = ref(false);
const showGraphLoader = ref(false);

const dateLabel = {
  publisher: 'Registered date:',
  activity: 'Activity Added on:',
  user: 'User Created Date:',
};

const currentView = ref('publisher');
const completeNess = ref();
const handleChangeTableNav = (item, filter, page) => {
  currentNav.value = item;
  fetchTableData(filter.value, page);
};

onMounted(() => {
  setDateRangeDate('', '');
  fetchTableData();
  fetchGraphData();
});
const downloadReport = () => {
  let params = new URLSearchParams();
  if (startDate.value && endDate.value) {
    params.append('start_date', startDate.value);
    params.append('end_date', endDate.value);
  }

  axios
    .get(`/dashboard/${currentView.value}/download`, { params: params })
    .then((res) => {
      const response = res.data;
      let blob = new Blob([response], {
        type: 'application/csv',
      });
      let link = document.createElement('a');
      link.href = window.URL.createObjectURL(blob);
      link.download = `${currentView.value}-report.csv`;
      link.click();
    });
};

const graphDataFormatter = (graphData) => {
  for (let date in graphData) {
    const data = {
      x: moment(date).format('MMM DD YYYY'),
      y: graphData[date],
    };
    graphAmount.value.push(data);
  }
};

const fetchGraphData = () => {
  showGraphLoader.value = true;
  let params = new URLSearchParams();
  params.append('start_date', startDate.value);
  params.append('end_date', endDate.value);

  axios
    .get(`/dashboard/${currentView.value}/count/`, { params: params })
    .then((res) => {
      graphAmount.value.length = 0;
      graphTotal.value = res.data.data['count'];
      graphDataFormatter(res.data.data['graph']);
    })
    .finally(() => {
      showGraphLoader.value = false;
    });
};

const setDateRangeDate = (start, end) => {
  startDate.value = start;
  endDate.value = end;
  fetchTableData();
  fetchGraphData();
};

watch(
  () => currentView.value,
  () => {
    DateLabel.value = dateLabel[currentView.value] ?? currentView.value;
    fetchGraphData();
  }
);

const fetchTableData = (filter = { orderBy: '', sort: '' }, page = '1') => {
  showTableLoader.value = true;
  let params = new URLSearchParams();
  if (filter.orderBy) {
    params.append('orderBy', filter.orderBy);
  }
  params.append('page', page);
  if (filter.sort) {
    params.append('direction', filter.sort);
  }

  if (startDate.value && endDate.value && currentNav.value.label !== 'user') {
    params.append('start_date', startDate.value);
    params.append('end_date', endDate.value);
  }

  const apiUrl = `/dashboard/${currentView.value}/${currentNav.value['apiParams']}`;

  axios
    .get(apiUrl, { params: params })
    .then((res) => {
      let response = res.data;

      if (currentView.value === 'publisher') {
        if (currentNav.value['apiParams'] !== 'setup') {
          tableData.value = [];
          let tempData: Array<object> = [];
          const codeList = response.data?.codelist;

          for (let key in response.data?.data) {
            const value = response.data?.data[key];
            let label = key;

            if (codeList) {
              label = codeList[key] ?? 'Unknown';
            }

            tempData.push({
              label: label,
              id: key,
              total: value,
            });
          }

          tableData.value = response.data;
          tableData.value.data = tempData;
        } else {
          completeNess.value = response.data;
        }
      }

      if (currentView.value === 'user' || currentView.value === 'activity') {
        tableData.value = response.data;
      }
    })
    .finally(() => {
      showTableLoader.value = false;
    });
};
provide('completeNess', completeNess);
provide('graphAmount', graphAmount);
provide('graphTotal', graphTotal);
provide('showTableLoader', showTableLoader);
provide('showGraphLoader', showGraphLoader);
</script>
