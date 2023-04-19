<template>
  <div
    class="fixed right-10 bottom-0 z-10 h-[80px] rounded-t-lg bg-eggshell p-6"
  >
    <div class="mb-3 flex h-1 w-full justify-start rounded-full bg-spring-10">
      <div
        :style="{ width: percentageWidth + '%' }"
        class="h-full rounded-full bg-spring-50"
      ></div>
    </div>
    <div class="flex justify-between space-x-5">
      <p
        v-if="totalCount === processedCount && totalCount !== 0"
        class="text-sm text-n-40"
      >
        {{ currentActivity }} file upload complete
      </p>
      <p v-else class="text-sm text-n-40">
        Uploading
        <span v-if="totalCount">
          {{ `${processedCount}  /  ${totalCount}` }}</span
        >
        '{{ currentActivity }}'
      </p>
      <spinnerLoader v-if="processedCount !== totalCount || totalCount === 0" />
      <button v-else class="text-xs font-bold uppercase text-spring-50">
        Proceed
      </button>
    </div>
  </div>
</template>
<script setup lang="ts">
import { defineProps, onMounted, ref, computed } from 'vue';
import spinnerLoader from './spinnerLoader.vue';
const currentActivity = ref(null);

const props = defineProps({
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
});
const mapActivityName = (name) => {
  switch (name) {
    case 'activity':
      return 'Basic Activity Elements';
    case 'period':
      return 'Basic Activity Elements';
    case 'indocator':
      return 'Basic Activity Elements';
    case 'result':
      return 'Basic Activity Elements';
    default:
      return name;
  }
};

onMounted(() => {
  currentActivity.value = mapActivityName(props.activityName);
});
const percentageWidth = computed(() => {
  if (props.totalCount !== 0) {
    return (props.processedCount / props.totalCount) * 100;
  } else {
    return 0;
  }
});
</script>
