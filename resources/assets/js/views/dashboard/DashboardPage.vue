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

interface tableDataType {
  label: string;
  total: number;
}
const currentNav = ref({
  label: 'Publisher Type',
  apiParams: 'publisher-type',
});
const tableData = ref<any>([]);
const DateLabel = ref('Registered date:');
const startDate = ref('1990-12-31');
const endDate = ref(moment(new Date()).format('YYYY-MM-DD'));
const graphDate = ref<string[]>([]);
const graphAmount = ref<object[]>([]);
const showTableLoader = ref(false);

const currentView = ref('publisher');
const completeNess = ref();
const handleChangeTableNav = (item, filter, page) => {
  currentNav.value = item;
  fetchTableData(filter.value, page);
};

onMounted(() => {
  setDateRangeDate('1990-12-31', moment(new Date()).format('YYYY-MM-DD'));
  fetchTableData();
  fetchGraphData();
});
const downloadReport = () => {
  axios.get(`/dashboard/${currentView.value}/download`).then((res) => {
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

const graphDataFormatter = (item) => {
  const monthConverter = (month) => {
    switch (month) {
      case '01':
        return 'Jan';

      case '02':
        return 'Feb';
      case '03':
        return 'Mar';
      case '04':
        return 'Apr';
      case '05':
        return 'May';
      case '06':
        return 'June';
      case '07':
        return 'July';
      case '08':
        return 'Aug';
      case '09':
        return 'Sep';
      case '10':
        return 'Oct';
      case '11':
        return 'Nov';
      case '12':
        return 'Dec';
      default:
        break;
    }
  };
  for (let x in item) {
    const data = {
      x: `${monthConverter(x.split('-')[1])} ${x.split('-')[2]} ${
        x.split('-')[0]
      } `,
      y: item[x],
    };
    graphAmount.value.push(data);
  }
};

const fetchGraphData = () => {
  let params = new URLSearchParams();
  params.append('start_date', startDate.value);
  params.append('end_date', endDate.value);

  axios
    .get(`/dashboard/${currentView.value}/count/`, { params: params })
    .then((res) => {
      graphAmount.value.length = 0;
      graphDataFormatter(res.data.data);
    });
};

const setDateRangeDate = (start, end) => {
  startDate.value = start;
  endDate.value = end;
  fetchTableData();
  fetchGraphData();
};

const mapApiParamsToVariable = (item) => {
  switch (item) {
    case 'publisher-type':
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
    fetchGraphData();
  }
);

const fetchTableData = (filter = { orderBy: '', sort: '' }, page = '1') => {
  showTableLoader.value = true;
  let apiUrl = `/dashboard/${currentView.value}/${currentNav.value['apiParams']}`;
  let params = new URLSearchParams();
  params.append('orderBy', filter.orderBy);
  params.append('page', page);

  params.append('direction', filter.sort);

  if (startDate.value && endDate.value && currentNav.value.label !== 'user') {
    apiUrl = `/dashboard/${currentView.value}/${currentNav.value['apiParams']}`;
    params.append('start_date', startDate.value);
    params.append('end_date', endDate.value);
  }
  axios
    .get(apiUrl, { params: params })
    .then((res) => {
      let response = res.data;

      if (currentView.value === 'publisher') {
        if (currentNav.value['apiParams'] !== 'setup') {
          tableData.value = [];

          response.data?.codelist &&
            Object.keys(response.data?.codelist)?.map((key) => {
              tableData.value.push({
                label: response.data?.codelist[key],
                id: key,
                total: null,
              });
            });

          response.data?.[
            mapApiParamsToVariable(currentNav.value['apiParams'])
          ] &&
            Object.keys(
              response.data?.[
                mapApiParamsToVariable(currentNav.value['apiParams'])
              ]
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
        tableData.value = response.data;
      }
      if (currentView.value === 'activity') {
        tableData.value = response.data;
      }
    })
    .finally(() => {
      showTableLoader.value = false;
    });
};
provide('completeNess', completeNess);
provide('graphDate', graphDate);
provide('graphAmount', graphAmount);
provide('showTableLoader', showTableLoader);
</script>
