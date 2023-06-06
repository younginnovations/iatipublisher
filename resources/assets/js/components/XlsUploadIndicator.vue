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
  </div>
</template>
<script setup lang="ts">
import XlsLoader from './XlsLoader.vue';
import BulkpublishWithXls from './BulkpublishWithXls.vue';
import { defineProps, ref } from 'vue';
import axios from 'axios';
import { useStore } from 'Store/activities/index';

const store = useStore();
const showXlsStatus = ref(true);

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

const closeXls = () => {
  showXlsStatus.value = false;
  axios.delete(`/import/xls`);
  store.dispatch('updateCancelUpload', true);
  setTimeout(() => {
    store.dispatch('updateCancelUpload', false), 1000;
  });
};
</script>
