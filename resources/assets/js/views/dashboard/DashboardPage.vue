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
      <div class="flex items-center space-x-2 outline">
        <DateRangeWidget
          :date-label="DateLabel"
          @trigger-set-date-range="setDateRangeDate"
        />

        <ButtonComponent
          text="Download report"
          class="p- bg-white"
          type="secondary"
          icon="download-file"
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
import ButtonComponent from 'Components/ButtonComponent.vue';
import axios from 'axios';

interface tableDataType {
  label: string;
  total: number;
}
const currentNav = ref({ label: 'Publisher Type', apiParams: 'type' });
const tableData = ref<any>([]);
const DateLabel = ref('Registered date:');
const startDate = ref('');
const endDate = ref('');
const graphDate = ref<string[]>([]);
const graphAmount = ref<object[]>([]);

const currentView = ref('publisher');
const completeNess = ref();
const handleChangeTableNav = (item) => {
  currentNav.value = item;

  fetchTableData();
};

onMounted(() => {
  fetchTableData();
  fetchGraphData();
});

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
      x: x,
      y: item[x],
    };
    graphAmount.value.push(data);

    // graphDate.value.push(
    //   `${monthConverter(rawDate[x].split('-')[1])} ${
    //     rawDate[x].split('-')[2]
    //   } ${rawDate[x].split('-')[0]}`
    // );
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
    fetchGraphData();
  }
);

const fetchTableData = () => {
  let apiUrl = `/dashboard/${currentView.value}/${currentNav.value['apiParams']}`;
  let params = new URLSearchParams();
  // if (startDate.value && endDate.value && currentNav.value.label !== 'user') {
  //   apiUrl = `/dashboard/${currentView.value}/${currentNav.value['apiParams']}/date-range`;
  //   params.append('start_date', startDate.value);
  //   params.append('end_date', endDate.value);
  // }
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
      tableData.value = response.data;
    }
    if (currentView.value === 'activity') {
      tableData.value = response.data;
    }
  });
};
provide('completeNess', completeNess);
provide('graphDate', graphDate);
provide('graphAmount', graphAmount);
</script>
