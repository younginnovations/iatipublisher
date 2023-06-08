<template>
  <div class="py-8 px-6">
    <div class="mb-3 flex justify-between border-b border-n-20 pb-3">
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
      <div>
        <DateRangeWidget
          :date-label="DateLabel"
          @trigger-set-date-range="setDateRangeDate"
        />
      </div>
    </div>
    <DashboardStatsSection :current-view="currentView" />
    <DashboardListSection
      :current-view="currentView"
      :table-data="tableData"
      :table-header="currentNav['label']"
      @table-nav="(n) => handleChangeTableNav(n)"
    />
  </div>
</template>

<script setup lang="ts">
import DashboardStatsSection from './DashboardStatsSection.vue';
import DashboardListSection from './DashboardListSection.vue';
import DateRangeWidget from 'Components/DateRangeWidget.vue';
import { ref, onMounted, provide, watch } from 'vue';
import axios from 'axios';

interface tableDataType {
  label: string;
  total: number;
}
const currentNav = ref('type');
const tableData = ref<any>([]);
const DateLabel = ref('Registered date:');
const startDate = ref('');
const endDate = ref('');

const currentView = ref('publisher');
const completeNess = ref();
const handleChangeTableNav = (item) => {
  currentNav.value = item;
  fetchTableData();
};

onMounted(() => {
  fetchTableData();
});

const setDateRangeDate = (start, end) => {
  startDate.value = start;
  endDate.value = end;
};

const mapApiParamsToVariable = (item) => {
  switch (item) {
    case 'type':
      return 'publisher_type';

    default:
      return item;
  }
};

const datetLabelMapper = (item) => {
  switch (item) {
    case 'publisher':
      return 'Registered date:';
    case 'activity':
      return 'Activity added on:';
    case 'user':
      return 'User Created Date:';

    default:
      return item;
  }
};

watch(
  () => currentView.value,
  () => {
    DateLabel.value = datetLabelMapper(currentView.value);
  }
);

const fetchTableData = () => {
  let apiUrl = `/dashboard/${currentView.value}/${currentNav.value['apiParams']}`;
  let params = new URLSearchParams();
  if (startDate.value && endDate.value) {
    apiUrl = `/dashboard/${currentView.value}/${currentNav.value['apiParams']}/date-range`;
    params.append('start_date', startDate.value);
    params.append('end_date', endDate.value);
  }
  axios.get(apiUrl, { params: params }).then((res) => {
    let response = res.data;

    if (currentView.value === 'publisher') {
      if (currentNav.value['apiParams'] !== 'setup') {
        tableData.value = [];

        Object.keys(response.data?.codelist)?.map((key) => {
          tableData.value.push({
            label: response.data?.codelist[key],
            id: key,
            total: null,
          });
        });

        Object.keys(
          response.data?.[mapApiParamsToVariable(currentNav.value['apiParams'])]
        )?.map((key) => {
          tableData.value.map((item, index) => {
            if (item.id == key) {
              tableData.value[index].total =
                response.data?.[
                  mapApiParamsToVariable(currentNav.value['apiParams'])
                ][key];
            }
          });
        });

        tableData.value = tableData.value.filter(function (el) {
          return el.total != null;
        });
      } else {
        completeNess.value = response.data;
      }
    }
    if (currentView.value === 'user') {
      tableData.value = response.data.data;
      console.log(tableData.value, 'users table data');
    }
  });
};
provide('completeNess', completeNess);
</script>
