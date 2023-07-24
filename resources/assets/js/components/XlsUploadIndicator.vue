<template>
  <div class="fixed right-10 bottom-0 z-[1000] flex items-end space-x-5">
    <BulkpublishWithXls
      v-if="showBulkPublishPopup"
      @toggle="
        (n) => {
          toggleBulkPublish = n;
        }
      "
      @close="closeBulkpublish"
    />
    <ActivityDownload v-if="showDownloadPopup" />
    <XlsLoader
      v-if="showXlsPopup"
      :total-count="totalCount"
      :processed-count="processedCount"
      :xls-failed="xlsFailed"
      :activity-name="activityName"
      :completed="completed"
      @close="closeXls"
    />
  </div>
</template>
<script setup lang="ts">
import ActivityDownload from './ActivityDownload.vue';
import XlsLoader from './XlsLoader.vue';
import BulkpublishWithXls from './BulkpublishWithXls.vue';
import {
  defineProps,
  ref,
  inject,
  watch,
  onUnmounted,
  onMounted,
  Ref,
  computed,
} from 'vue';
import axios from 'axios';
import { useStore } from 'Store/activities/index';
const store = useStore();
const showXlsStatus = ref(true);
import { useStorage } from '@vueuse/core';

const downloadCompleted = ref(false);
const toggleBulkPublish = ref(false);

const cancelDownload = ref(false);
const showBulkpublish = ref(true);
const publishingActivities = ref<string[]>([]);
const bulkPublishLength = ref(0);
const pa = useStorage('vue-use-local-storage', {
  publishingActivities: localStorage.getItem('publishingActivities') ?? {},
});
const props = defineProps({
  activityName: {
    type: String,
    required: true,
  },
  completed: {
    type: Boolean,
    required: false,
    default: false,
  },
  totalCount: {
    type: Number || null,
    default: 0,
  },
  processedCount: {
    type: Number,
    default: 0,
  },
  xlsFailed: {
    type: Boolean,
    default: false,
  },
  xlsData: {
    type: Boolean,
  },
});
onMounted(() => {
  publishingActivities.value =
    pa.value.publishingActivities && Object.keys(pa.value.publishingActivities);
  const checkSupportButton = setInterval(() => {
    const supportButton: HTMLElement = document.querySelector(
      '#launcher'
    ) as HTMLElement;

    if (supportButton !== null) {
      supportButton.style.transform = 'translatey(-50px)';
      if (
        !(props.xlsData && showXlsStatus) &&
        !(downloading && !downloadCompleted.value && !cancelDownload.value) &&
        showBulkpublish &&
        publishingActivities.value &&
        publishingActivities.value.length > 0
      ) {
        // supportButton.style.transform = 'translate(-350px ,0px)';
      }

      clearInterval(checkSupportButton);
    }
  }, 10);
});

watch(
  () => [store.state.startBulkPublish, store.state.bulkpublishActivities],
  (value) => {
    if (value) {
      publishingActivities.value =
        store.state.bulkpublishActivities.publishingActivities &&
        Object.keys(store.state.bulkpublishActivities.publishingActivities);

      publishingActivities.value =
        pa.value.publishingActivities &&
        Object.keys(pa.value.publishingActivities);

      return;
    }
  },
  { deep: true }
);
watch(
  () => store.state.startBulkPublish,
  () => {
    showBulkpublish.value = true;
  },
  { deep: true }
);

watch(
  () => props.xlsData,
  (value) => {
    if (value) {
      showXlsStatus.value = true;
    }
  }
);

watch(
  () => [
    props.xlsData,
    showXlsStatus.value,
    downloading,
    downloadCompleted.value,
    cancelDownload.value,
    toggleBulkPublish.value,
  ],
  () => {
    const supportButton: HTMLElement = document.querySelector(
      '#launcher'
    ) as HTMLElement;

    if (
      !showXlsPopup.value &&
      !showDownloadPopup.value &&
      showBulkPublishPopup &&
      toggleBulkPublish.value
    ) {
      setTimeout(() => {
        if (supportButton !== null) {
          supportButton.style.transform = 'translate(-350px ,0px)';
        }
      }, 100);
    } else {
      if (supportButton !== null) {
        supportButton.style.transform = 'translatey(-50px)';
      }
    }
  }
);

const showBulkPublishPopup = computed(() => {
  return (
    showBulkpublish.value &&
    activities.value &&
    Object.keys(activities.value).length > 0
  );
});
const showDownloadPopup = computed(() => {
  return downloading.value && !downloadCompleted.value && !cancelDownload.value;
});

const showXlsPopup = computed(() => {
  return props.xlsData && showXlsStatus.value;
});

onUnmounted(() => {
  const supportButton: HTMLElement = document.querySelector(
    '#launcher'
  ) as HTMLElement;

  if (supportButton !== null) {
    if (
      bulkPublishLength.value > 0 ||
      Object.keys(pa.value.publishingActivities).length > 0
    ) {
      supportButton.style.transform = 'translate(-350px ,-20px)';
    } else {
      supportButton.style.transform = 'translateY(-65px)';
    }
  }
});

const closeBulkpublish = () => {
  showBulkpublish.value = false;
  localStorage.setItem('vue-use-local-storage', 'publishingActivities:{}');
  store.dispatch('updateBulkpublishActivities', {});
  axios.delete(`/activities/delete-bulk-publish-status`);
};

const closeXls = () => {
  showXlsStatus.value = false;
  axios.delete(`/import/xls`).then(() => {
    store.dispatch('updateCancelUpload', true);
    store.dispatch('updateCloseXlsModel', true);
    setTimeout(() => store.dispatch('updateCloseXlsModel', false), 2000);
  });
};
watch(
  () => store.state.completeXlsDownload,
  (value) => {
    if (value) {
      downloadCompleted.value = true;
    }
    downloadCompleted.value = false;
  },
  { deep: true }
);
watch(
  () => store.state.bulkPublishLength,
  (value) => {
    bulkPublishLength.value = value;
  },
  { deep: true }
);

watch(
  () => store.state.cancelDownload,
  (value) => {
    cancelDownload.value = value;
  },
  { deep: true }
);
const downloading = inject('downloading') as Ref;
const activities = inject('activities') as Ref;
</script>
