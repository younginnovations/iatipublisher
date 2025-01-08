<template>
  <div>
    <div class="flex items-center gap-1">
      <svg-vue icon="warning-activity" />
      <p class="text-sm font-bold text-n-50">
        Core Elements not complete in
        {{ coreInCompletedActivities.length }} activities
      </p>
    </div>
    <div class="mt-[10px] rounded-lg bg-paper p-4">
      <p class="text-sm text-n-50">
        Review the Core Completeness percentage under the '<b
          >Core Completeness</b
        >' column in your activity list to ensure optimal data quality. A higher
        percentage indicates better completeness.
      </p>
      <p>
        <svg-vue class="h-full w-full" icon="core-completeness" />
      </p>
    </div>
  </div>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';

defineProps({
  coreInCompletedActivities: {
    type: Object,
    default: () => ({}),
  },
  coreCompletedActivities: {
    type: Object,
    default: () => ({}),
  },
  deprecationStatusMap: {
    type: Object,
    default: () => ({}),
  },
  permalink: {
    type: String,
    default: () => '',
  },
});
</script>
