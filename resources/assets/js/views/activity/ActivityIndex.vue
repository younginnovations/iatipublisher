<template>
  <div
    id="activity-listing-page"
    class="page-height bg-paper px-5 pb-[71px] pt-4 xl:px-10"
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
    <XlsUploadIndicator
      v-if="
        (xlsData ||
          store.state.startValidation ||
          (downloading && !downloadCompleted) ||
          publishingActivities ||
          startBulkPublish) &&
        !activityStore.state.isLoading
      "
      :total-count="totalCount"
      :processed-count="processedCount"
      :xls-failed="xlsFailed"
      :activity-name="activityName"
      :xls-data="xlsData"
      :completed="uploadComplete"
    />
  </div>
</template>

<script lang="ts">
import {
  defineComponent,
  onMounted,
  provide,
  reactive,
  ref,
  watch,
  Ref,
} from 'vue';
import { watchIgnorable } from '@vueuse/core';
import axios from 'axios';
import XlsUploadIndicator from 'Components/XlsUploadIndicator.vue';
import EmptyActivity from './partials/EmptyActivity.vue';
import TableLayout from './partials/TableLayout.vue';
import Pagination from 'Components/TablePagination.vue';
import PageTitle from './partials/PageTitle.vue';
import Loader from 'Components/Loader.vue';
import ErrorMessage from 'Components/ErrorMessage.vue';
import { useStore } from 'Store/activities/index';
import { detailStore } from 'Store/activities/show';
import { useStorage } from '@vueuse/core';

const store = useStore();
const activityStore = detailStore();
export default defineComponent({
  name: 'ActivityComponent',
  components: {
    EmptyActivity,
    PageTitle,
    Pagination,
    TableLayout,
    Loader,
    ErrorMessage,
    XlsUploadIndicator,
  },
  props: {
    toast: {
      type: Object,
      required: true,
    },
    defaultLanguage: {
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
    const fileCount = ref(0);
    const downloadCompleted = ref(false);
    const closeModel = ref(false);
    const xlsDownloadStatus = ref('');
    const xlsData = ref(false);
    const downloading = ref(false);
    const startBulkPublish = ref(false);
    const xlsFailed = ref(false);
    const xlsFailedMessage = ref('');
    const processing = ref();
    const publishingActivities = ref();
    const uploadComplete = ref(false);
    const importCompleted = ref(false);
    const totalCount = ref();
    const processedCount = ref();
    const showXlsStatus = ref(true);
    const tableLoader = ref(true);
    const downloadApiUrl = ref('');
    const currentURL = window.location.href;
    let endpoint = '';
    let showEmptyTemplate = false;

    // local storage for publishing
    interface paType {
      publishingActivities: {
        organization_id?: string;
        job_batch_uuid?: string;
        activities?: object;
        status?: string;
        message?: string;
      };
    }

    const pa: Ref<paType> = useStorage('vue-use-local-storage', {
      publishingActivities: localStorage.getItem('publishingActivities') ?? {},
    });

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
      visibility: false,

      message: '',
      type: false,
    });
    const pollingForXlsStatus = () => {
      const checkStatus = setInterval(function () {
        axios.get('/import/xls/status').then((res) => {
          if (res.data.data?.message === 'Started') {
            //reset
            totalCount.value = null;
            processedCount.value = 0;
            xlsFailed.value = false;
            xlsFailedMessage.value = '';
          } else {
            totalCount.value = res.data.data?.total_count;
            processedCount.value = res.data.data?.processed_count;
            xlsFailed.value = !res.data.data?.success;
            xlsFailedMessage.value = res.data.data?.message;
          }

          if (res.data.data?.message === 'Processing') {
            processing.value = true;
          }

          if (
            !res.data?.data?.success ||
            res.data?.data?.message === 'Complete'
          ) {
            uploadComplete.value = true;
            clearInterval(checkStatus);
          }
        });
      }, 2500);
    };
    watch(
      () => store.state.startXlsDownload,
      (value) => {
        if (value) {
          checkDownloadStatus();
        }
      },
      { deep: true }
    );

    watch(
      () => [store.state.startBulkPublish, store.state.bulkpublishActivities],
      (value) => {
        if (value) {
          startBulkPublish.value = true;
          publishingActivities.value =
            store.state.bulkpublishActivities.publishingActivities;
          return;
        }
        startBulkPublish.value = false;
      },
      { deep: true }
    );
    watch(
      () => store.state.completeXlsDownload,
      (value) => {
        if (value) {
          downloadCompleted.value = true;
          store.dispatch('updateStartXlsDownload', false);
        }
      },
      { deep: true }
    );
    watch(
      () => store.state.closeXlsModel,
      (value) => {
        if (value) {
          checkXlsstatus();
        }
      }
    );

    const checkXlsstatus = () => {
      axios.get('/import/xls/progress_status').then((res) => {
        activityName.value = res?.data?.status?.template;
        xlsData.value = Object.keys(res.data.status).length > 0;

        if (res?.data?.status?.status === 'completed') {
          uploadComplete.value = true;
        } else if (res?.data?.status?.status === 'failed') {
          xlsFailed.value = true;
          xlsFailedMessage.value = res?.data?.status?.message;
        } else if (Object.keys(res.data.status).length > 0) {
          {
            //reset
            totalCount.value = null;
            processing.value = false;
            processedCount.value = 0;
            xlsFailed.value = false;
            xlsFailedMessage.value = '';

            pollingForXlsStatus();
          }
        }
      });
    };
    const checkDownloadStatus = () => {
      downloading.value = false;

      const checkDownload = setInterval(function () {
        axios.get('/activities/download-xls-progress-status').then((res) => {
          fileCount.value = res.data.file_count;
          xlsDownloadStatus.value = res.data.status;
          downloadApiUrl.value = res.data.url;
          downloading.value = !!res.data.status;
          if (
            xlsDownloadStatus.value === 'completed' ||
            xlsDownloadStatus.value === 'failed' ||
            !res.data.status
          ) {
            clearInterval(checkDownload);
          }
        });
      }, 3000);
    };

    watch(
      () => store.state.closeXlsModel,
      () => {
        checkDownloadStatus();
      }
    );

    onMounted(() => {
      publishingActivities.value = pa.value?.publishingActivities;

      checkXlsstatus();
      checkDownloadStatus();

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

    console.log(activities, 'activities');

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
    provide('xlsFailedMessage', xlsFailedMessage);
    provide('processing', processing);
    provide('downloading', downloading);
    provide('fileCount', fileCount as Ref);
    provide('xlsDownloadStatus', xlsDownloadStatus as Ref);
    provide('downloadApiUrl', downloadApiUrl as Ref);
    provide('closeModel', closeModel as Ref);
    provide('activities', publishingActivities as Ref);
    provide('completed', uploadComplete);
    provide('defaultLanguage', props.defaultLanguage);

    return {
      store,
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
      showXlsStatus,
      xlsFailed,
      xlsFailedMessage,
      importCompleted,
      downloadCompleted,
      uploadComplete,
      downloading,
      startBulkPublish,
      publishingActivities,
      activityStore,
      pa,
    };
  },
});
</script>

<style lang="scss">
.page-height {
  min-height: calc(100vh - 60px);
}
</style>
