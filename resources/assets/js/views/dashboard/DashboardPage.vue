<template>
  <div class="py-8 px-6">
    <div class="mb-3 border-b border-n-20 pb-3">
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
    </div>
    <DashboardStatsSection :current-view="currentView" />
    <DashboardListSection
      :current-view="currentView"
      :table-data="tableData"
      @table-nav="(n) => handleChangeTableNav(n)"
    />
  </div>
</template>

<script setup lang="ts">
import DashboardStatsSection from './DashboardStatsSection.vue';
import DashboardListSection from './DashboardListSection.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';

interface tableDataType {
  label: string;
  total: number;
}

const currentNav = ref('type');
const tableData = ref<any>([]);
const currentView = ref('publisher');
const handleChangeTableNav = (item) => {
  currentNav.value = item;
  fetchTableData();
};

onMounted(() => {
  fetchTableData();
});

const fetchTableData = () => {
  axios
    .get(`/dashboard/${currentView.value}/${currentNav.value}`)
    .then((res) => {
      let response = res.data;
      Object.keys(response.data?.codelist)?.map((key) => {
        console.log(response.data?.codelist, 'item');
        tableData.value.push({
          label: response.data?.codelist[key],
          id: key,
          total: null,
        });
      });

      Object.keys(response.data?.publisher_type)?.map((key) => {
        tableData.value.map((item, index) => {
          if (item.id == key) {
            tableData.value[index].total = response.data?.publisher_type[key];
          }
        });
      });

      tableData.value = tableData.value.filter(function (el) {
        return el.total != null;
      });
      console.log(tableData.value);
    });
};
</script>
