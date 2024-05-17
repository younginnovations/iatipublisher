<template>
  <div class="relative">
    <h3 class="pb-2 text-base font-bold leading-6 text-n-50">Importing</h3>
    <div
      class="relative rounded-lg border border-n-20 bg-white p-4 duration-200"
    >
      <button
        v-if="totalCount === processedCount || xlsFailed"
        class="absolute right-0 top-0 -translate-y-1/2 translate-x-1/2 rounded-full bg-white p-[1px]"
        @click="$emit('close')"
      >
        <svg-vue class="text-sm" icon="cross-icon" />
      </button>
      <div class="flex items-center justify-between">
        <h3
          class="flex items-center space-x-2 text-sm leading-[22px] text-n-50"
        >
          <span>Multiple Activities</span>
          <span
            class="flex h-6 w-6 items-center justify-center rounded-full bg-lagoon-10 text-lagoon-50"
            >{{ totalCount ?? 0 }}</span
          >
        </h3>
        <button
          @click="
            () => {
              $emit('close');
            }
          "
        >
          <svg-vue class="text-sm text-n-40" icon="delete" />
        </button>
      </div>
      <div v-if="!xlsFailed" class="my-3 flex items-center">
        <div
          class="mr-2 flex h-1 w-[calc(100%_-_10px)] justify-start rounded-full bg-spring-10"
        >
          <div
            :style="{ width: percentageWidth + '%' }"
            class="h-full rounded-full bg-spring-50"
          ></div>
        </div>
        <span class="text-sm text-[#344054]">
          {{ Math.trunc(percentageWidth) }}%
        </span>
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
        <p v-if="completed" class="text-sm text-n-40">
          {{ currentActivity }} file upload complete
        </p>
        <p v-else class="text-sm text-n-40">
          Uploading
          <span v-if="totalCount && processing">
            {{ `${processedCount} / ${totalCount}` }}</span
          >
          '{{ currentActivity }}'
        </p>
        <a
          v-if="completed"
          href="/import/xls/list"
          class="text-xs font-bold uppercase text-spring-50 hover:text-spring-50"
        >
          Proceed
        </a>
        <spinnerLoader v-else />
      </div>
    </div>
  </div>
</template>
<script setup lang="ts">
import {
  defineProps,
  onMounted,
  defineEmits,
  inject,
  ref,
  computed,
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
});

const percentageWidth = computed(() => {
  if (props.totalCount !== 0 && props.totalCount !== null) {
    return (props.processedCount / props.totalCount) * 100;
  } else if (props.completed) {
    return 100;
  } else {
    return 0;
  }
});

const xlsFailedMessage = inject('xlsFailedMessage');
const processing = inject('processing');
</script>
