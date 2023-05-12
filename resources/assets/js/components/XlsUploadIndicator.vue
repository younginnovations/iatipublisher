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
import { defineProps, ref, inject, watch, onUnmounted } from 'vue';
import axios from 'axios';
import { useStore } from 'Store/activities/index';
const store = useStore();
const showXlsStatus = ref(true);
const downloadCompleted = ref(false);
const cancelDownload = ref(false);

defineProps({
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

onUnmounted(() => {
  const supportButton: HTMLElement = document.querySelector(
    '#launcher'
  ) as HTMLElement;

  if (supportButton !== null) {
    supportButton.style.transform = 'translatey(-30px)';
  }
});

const closeXls = () => {
  showXlsStatus.value = false;
  axios.delete(`/import/xls`);
  store.dispatch('updateCancelUpload', true);
  setTimeout(() => {
    store.dispatch('updateCancelUpload', false), 1000;
  });
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
  () => store.state.cancelDownload,
  (value) => {
    cancelDownload.value = value;
  },
  { deep: true }
);
const downloading = inject('downloading');
</script>
