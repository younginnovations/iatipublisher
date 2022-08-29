<template>
  <div
    id="activity-listing-page"
    class="page-height bg-paper px-10 pt-4 pb-[71px]"
  >
    <div id="activity">
      <Loader v-if="isLoading"></Loader>
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
import { defineComponent, onMounted, provide, reactive, ref } from 'vue';
import axios from 'axios';

import EmptyActivity from './partials/EmptyActivity.vue';
import TableLayout from './partials/TableLayout.vue';
import Pagination from 'Components/TablePagination.vue';
import PageTitle from './partials/PageTitle.vue';
import Loader from 'Components/Loader.vue';

export default defineComponent({
  name: 'ActivityComponent',
  components: {
    EmptyActivity,
    PageTitle,
    Pagination,
    TableLayout,
    Loader,
  },
  props: {
    toast: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    const activities = reactive({});
    const isLoading = ref(true);

    //for session message
    const toastData = reactive({
      visibility: false,
      message: '',
      type: true,
    });

    // for publish button
    const toastMessage = reactive({
      message: '',
      type: false,
    });

    onMounted(() => {
      if (props.toast.message !== '') {
        toastData.type = props.toast.type;
        toastData.visibility = true;
        toastData.message = props.toast.message;
      }

      setTimeout(() => {
        toastData.visibility = false;
      }, 5000);
    });

    onMounted(async () => {
      axios.get('/activity/page').then((res) => {
        const response = res.data;
        Object.assign(activities, response.data);
        isEmpty.value = response.data.data.length ? false : true;
        isLoading.value = false;
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
      axios.get('/activity/page/' + active_page).then((res) => {
        const response = res.data;
        Object.assign(activities, response.data);
        isEmpty.value = response.data ? false : true;
      });
    }

    provide('toastMessage', toastMessage);
    provide('toastData', toastData);

    return {
      activities,
      state,
      isEmpty,
      isLoading,
      showOrHide,
      fetchActivities,
      toastData,
      toastMessage,
    };
  },
});
</script>

<style lang="scss">
.page-height {
  min-height: calc(100vh - 60px);
}
</style>
