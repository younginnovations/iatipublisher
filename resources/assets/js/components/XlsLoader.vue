<template>
  <div class="h-[80px] rounded-t-lg bg-eggshell p-6">
    <div
      v-if="!xlsFailed"
      class="mb-3 flex h-1 w-full justify-start rounded-full bg-spring-10"
    >
      <div
        :style="{ width: completed ? '100%' : percentageWidth + '%' }"
        class="h-full rounded-full bg-spring-50"
      ></div>
    </div>
    <div v-if="xlsFailed" class="flex justify-between space-x-5">
      <div>
        <p class="text-sm font-bold text-crimson-50">
          {{ currentActivity }} upload failed:
        </p>

        <p class="text-sm text-crimson-50">{{ xlsFailedMessage }}</p>
      </div>
      <button
        class="text-xs font-bold uppercase text-crimson-50 hover:text-spring-50"
        @click="retry"
      >
        Retry
      </button>
    </div>
    <div v-else class="flex justify-between space-x-5">
      <p
        v-if="(totalCount === processedCount && totalCount !== 0) || completed"
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
      <spinnerLoader
        v-if="(processedCount !== totalCount || totalCount === 0) && !completed"
      />
      <a
        v-else
        href="/import/xls/list"
        class="text-xs font-bold uppercase text-spring-50 hover:text-spring-50"
      >
        Proceed
      </a>
    </div>
  </div>
  <button
    v-if="(totalCount === processedCount && totalCount !== 0) || xlsFailed"
    class="absolute right-0 bottom-[80px] translate-x-4 rounded-full bg-white p-[1px]"
    @click="$emit('close')"
  >
    <svg-vue icon="cross-icon" />
  </button>
</template>
<script setup lang="ts">
import {
  defineProps,
  onMounted,
  defineEmits,
  onUpdated,
  inject,
  ref,
  computed,
  onUnmounted,
} from 'vue';
import spinnerLoader from './spinnerLoader.vue';
import axios from 'axios';

const currentActivity = ref(null);
defineEmits(['close']);

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
});
const mapActivityName = (name) => {
  switch (name) {
    case 'activity':
      return 'Basic Activity Elements';
    case 'period':
      return 'Period';
    case 'indicator':
      return 'Indicators except Period';
    case 'result':
      return 'Result except Indicators and Period';
    default:
      return name;
  }
};

const retry = () => {
  axios.delete(`/import/xls`);
  window.location.href = '/import/xls';
};

onMounted(() => {
  currentActivity.value = mapActivityName(props.activityName);
  console.log(';moun');
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
onUpdated(() => {
  console.log(xlsFailedMessage);
});

onUnmounted(() => {
  const supportButton: HTMLElement = document.querySelector(
    '#launcher'
  ) as HTMLElement;

  if (supportButton !== null) {
    supportButton.style.transform = 'translatey(0px)';
  }
});

const percentageWidth = computed(() => {
  if (props.totalCount !== 0) {
    return (props.processedCount / props.totalCount) * 100;
  } else {
    return 0;
  }
});

const xlsFailedMessage = inject('xlsFailedMessage');
</script>
