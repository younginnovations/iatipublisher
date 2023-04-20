<template>
  <div class="fixed right-10 bottom-0 z-[1000] flex items-end space-x-5">
    <BulkpublishWithXls />
    <XlsLoader
      v-if="xlsData && showXlsStatus"
      :total-count="totalCount"
      :processed-count="processedCount"
      :xls-failed="xlsFailed"
      :activity-name="activityName"
      @close="showXlsStatus = false"
    />
  </div>
</template>
<script setup lang="ts">
import XlsLoader from './XlsLoader.vue';
import BulkpublishWithXls from './BulkpublishWithXls.vue';
import { defineProps, ref } from 'vue';
const showXlsStatus = ref(true);

defineProps({
  activityName: {
    type: String,
    required: true,
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
</script>
