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
        The incomplete activities are marked with icon
        <span class="inline-block">
          <svg-vue icon="warning-activity" />
        </span>
        in your activities list. We recommend completing them to ensure better
        data quality.
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
