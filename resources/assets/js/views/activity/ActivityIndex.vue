<template>
  <div
    id="activity-listing-page"
    class="page-height bg-paper px-5 pt-4 pb-[71px] xl:px-10"
  >
    <div id="activity">
      <Loader v-if="isLoading"></Loader>
      <PageTitle />
      <div class="overflow-hidden" :class="{ 'bg-white': isEmpty }">
        <ErrorMessage :is-empty="isEmpty"></ErrorMessage>
        <EmptyActivity v-if="isEmpty" />
        <TableLayout
          v-if="!isEmpty"
          :data="activities"
          :loader="tableLoader"
          @show-or-hide="showOrHide"
        />
        <div v-if="!isEmpty" class="mt-6">
          <Pagination
            v-if="activities && activities.last_page > 1"
            :data="activities"
            @fetch-activities="fetchActivities"
          />
        </div>
      </div>
    </div>
    <xlsLoader
      v-if="xlsData"
      :total-count="totalCount"
      :processed-count="processedCount"
      :activity-name="activityName"
    />
  </div>
</template>

<script lang="ts">
import { defineComponent, onMounted, provide, reactive, ref, watch } from 'vue';
import { watchIgnorable } from '@vueuse/core';
import axios from 'axios';
import xlsLoader from 'Components/XlsLoader.vue';
import EmptyActivity from './partials/EmptyActivity.vue';
import TableLayout from './partials/TableLayout.vue';
import Pagination from 'Components/TablePagination.vue';
import PageTitle from './partials/PageTitle.vue';
import Loader from 'Components/Loader.vue';
import ErrorMessage from 'Components/ErrorMessage.vue';

export default defineComponent({
  name: 'ActivityComponent',
  components: {
    EmptyActivity,
    PageTitle,
    Pagination,
    TableLayout,
    Loader,
    ErrorMessage,
    xlsLoader,
  },
  props: {
    toast: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    interface ActivitiesInterface {
      last_page: number;
    }
    const activities = reactive({}) as ActivitiesInterface;
    const isLoading = ref(true);
    const activityName = ref('');

    const xlsData = ref(false);
    const totalCount = ref();
    const processedCount = ref();

    const tableLoader = ref(true);
    const currentURL = window.location.href;
    let endpoint = '';
    let showEmptyTemplate = false;

    if (currentURL.includes('?')) {
      const queryString = window.location.search;
      endpoint = `/activities/page${queryString}`;
    } else {
      endpoint = `/activities/page`;
      showEmptyTemplate = true;
    }

    //for session message
    const toastData = reactive({
      visibility: false,
      message: '',
      type: true,
    });
    const errorData = reactive({
      visibility: false,
      message: '',
      type: true,
    });

    // for publish button
    const toastMessage = reactive({
      message: '',
      type: false,
    });

    const checkXlsstatus = () => {
      let count = 0;
      console.log('checkstatus');

      axios.get('/import/xls/progress_status').then((res) => {
        console.log(res.data, 'templete');
        activityName.value = res?.data?.status?.template;
        xlsData.value = !!res.data.status;

        if (res.data.status) {
          const checkStatus = setInterval(function () {
            axios.get('/import/xls/status').then((res) => {
              console.log(res.data, count);
              totalCount.value = res.data.data.total_count;
              processedCount.value = res.data.data.processed_count;
            });
            count++;
            if (count > 20) {
              clearInterval(checkStatus);
            }
          }, 2000);
        }
      });
    };

    onMounted(() => {
      checkXlsstatus();
      if (props.toast.message !== '') {
        toastData.type = props.toast.type;
        toastData.visibility = true;
        toastData.message = props.toast.message;
      }
    });

    onMounted(async () => {
      tableLoader.value = true;
      axios.get(endpoint).then((res) => {
        const response = res.data;
        Object.assign(activities, response.data);
        isLoading.value = false;
        tableLoader.value = false;

        if (showEmptyTemplate) {
          isEmpty.value = !response.data.data.length;
        }
      });
    });
    watch(
      () => toastData.visibility,
      () => {
        setTimeout(() => {
          toastData.visibility = false;
          ignoreToastUpdate();
        }, 10000);
      }
    );
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
      tableLoader.value = true;
      let queryString = '';
      if (currentURL.includes('?')) {
        queryString = window.location.search;
      }
      axios.get('/activities/page/' + active_page + queryString).then((res) => {
        const response = res.data;
        Object.assign(activities, response.data);
        isEmpty.value = !response.data;
      });
      tableLoader.value = false;
    }

    const { ignoreUpdates } = watchIgnorable(toastData, () => undefined, {
      flush: 'sync',
    });

    const ignoreToastUpdate = () => {
      ignoreUpdates(() => {
        toastData.message = '';
      });
    };

    // for refresh toast message
    // let refreshToastMsg = ref(false);
    const refreshToastMsg = reactive({
      visibility: false,
      refreshMessageType: true,
      refreshMessage:
        'Activity has been published successfully, refresh to see changes',
    });

    /**
     * Provide
     */
    provide('toastMessage', toastMessage);
    provide('toastData', toastData);
    provide('errorData', errorData);
    provide('refreshToastMsg', refreshToastMsg);

    return {
      activities,
      state,
      isEmpty,
      isLoading,
      showOrHide,
      fetchActivities,
      toastData,
      toastMessage,
      refreshToastMsg,
      errorData,
      tableLoader,
      xlsData,
      activityName,
      processedCount,
      totalCount,
    };
  },
});
</script>

<style lang="scss">
.page-height {
  min-height: calc(100vh - 60px);
}
</style>
