<template>
  <div class="fixed right-10 bottom-0 z-[1000] flex items-end space-x-5">
    <BulkpublishWithXls />

    <XlsLoader
      v-if="xlsData && showXlsStatus"
      :total-count="totalCount"
      :processed-count="processedCount"
      :xls-failed="xlsFailed"
      :activity-name="activityName"
      :completed="completed"
      @close="closeXls"
    />
    <ActivityDownload
      v-if="downloading && !downloadCompleted && !cancelDownload"
    />
  </div>
</template>
<script setup lang="ts">
import ActivityDownload from './ActivityDownload.vue';
import XlsLoader from './XlsLoader.vue';
import BulkpublishWithXls from './BulkpublishWithXls.vue';
import { defineProps, ref, inject, watch, onUnmounted, onMounted } from 'vue';
import axios from 'axios';
import { useStore } from 'Store/activities/index';
const store = useStore();
const showXlsStatus = ref(true);
import { useStorage } from '@vueuse/core';

const downloadCompleted = ref(false);
const cancelDownload = ref(false);
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
    type: Number,
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
  const checkSupportButton = setInterval(() => {
    const supportButton: HTMLElement = document.querySelector(
      '#launcher'
    ) as HTMLElement;

    if (supportButton !== null) {
      supportButton.style.transform = 'translatey(-50px)';

      clearInterval(checkSupportButton);
    }
  }, 10);
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
      supportButton.style.transform = 'translateY(-50px)';
    }
  }
});

const closeXls = () => {
  showXlsStatus.value = false;
  axios.delete(`/import/xls`);
};
watch(
  () => store.state.completeXlsDownload,
  (value) => {
    if (value) {
      downloadCompleted.value = true;
    }
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
// watch(
//   () => [
//     props.xlsData,
//     showXlsStatus.value,
//     downloading,
//     downloadCompleted.value,
//     cancelDownload.value,
//   ],
//   ([
//     xlsData,
//     showXlsStatus,
//     downloading,
//     downloadCompleted,
//     cancelDownload,
//   ]) => {
//     if (
//       !(xlsData && showXlsStatus) &&
//       !(downloading && !downloadCompleted && !cancelDownload) &&
//       (bulkPublishLength.value > 0 ||
//         Object.keys(pa.value.publishingActivities).length > 0)
//     ) {
//       const supportButton: HTMLElement = document.querySelector(
//         '#launcher'
//       ) as HTMLElement;

//       if (supportButton !== null) {
//         supportButton.style.transform = 'translate(-350px ,-20px)';
//       }
//     }
//   }
// );
watch(
  () => store.state.cancelDownload,
  (value) => {
    cancelDownload.value = value;
  },
  { deep: true }
);
const downloading = inject('downloading');
</script>
