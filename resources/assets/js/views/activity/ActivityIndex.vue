<template>
  <div
    id="activity-listing-page"
    class="listing__page bg-paper px-10 pt-4 pb-[71px]"
  >
    <div id="activity">
      <PageTitle :show-buttons="state.showButtons" />
      <EmptyActivity v-if="isEmpty" />
      <TableLayout
        v-if="!isEmpty"
        :data="activities"
        @show-or-hide="showOrHide"
      />
      <div v-if="!isEmpty" class="mt-6">
        <Pagination :data="activities" @fetch-activities="fetchActivities" />
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, onMounted, reactive, ref } from 'vue';
import axios from 'axios';

import EmptyActivity from './partials/EmptyActivity.vue';
import TableLayout from './partials/TableLayout.vue';
import Pagination from 'Components/TablePagination.vue';
import PageTitle from './partials/PageTitle.vue';

export default defineComponent({
  name: 'ActivityComponent',
  components: {
    EmptyActivity,
    PageTitle,
    Pagination,
    TableLayout,
  },
  setup() {
    const activities = reactive({});

    onMounted(async () => {
      axios.get('/activities/page').then((res) => {
        const response = res.data;
        Object.assign(activities, response.data);
        isEmpty.value = response.data.data.length ? false : true;
      });
    });

    const state = reactive({
      showButtons: false,
    });

    const isEmpty = ref(false);

    const showOrHide = (data = Array) => {
      if (data.length > 0) {
        state.showButtons = true;
      } else {
        state.showButtons = false;
      }
    };

    function fetchActivities(active_page: number) {
      axios.get('/activities/page/' + active_page).then((res) => {
        const response = res.data;
        Object.assign(activities, response.data);
        isEmpty.value = response.data ? false : true;
      });
    }

    return { activities, state, isEmpty, showOrHide, fetchActivities };
  },
});
</script>

<style lang="scss">
.listing__page {
  min-height: calc(100vh - 60px);
}
</style>
