<template>
  <div
    :class="
      maximize
        ? 'bottom-1/2 right-1/2 translate-y-1/2 translate-x-1/2 p-6'
        : ' bottom-0 right-10 translate-y-full'
    "
    class="!fixed z-[100] rounded bg-eggshell duration-300"
  >
    <div class="mb-5 flex items-start justify-between">
      <h6 v-if="maximize && xlsFailed" class="font-bold">Upload Failed</h6>

      <h6 v-if="maximize && !xlsFailed" class="font-bold">
        Upload in progress
      </h6>
      <div v-if="maximize" class="flex items-center space-x-3">
        <button
          class="text-xs font-bold uppercase text-bluecoral"
          @click="maximize = !maximize"
        >
          <svg-vue class="w-[16px] text-n-50" icon="minimize" />
        </button>
        <button
          @click="
            () => {
              $emit('close');
            }
          "
        >
          <svg-vue class="w-[12px] text-n-50" icon="cancel-cross" />
        </button>
      </div>
    </div>
    <div
      :class="xlsFailed && '!border-crimson-20 !bg-rose'"
      class="relative min-h-[80px] min-w-[430px] rounded-lg border border-n-20 p-4 duration-200"
    >
      <p
        class="text-sm font-bold text-bluecoral"
        :class="xlsFailed && ' text-crimson-50'"
      >
        Uploading '{{ currentActivity }}' file
      </p>

      <div
        v-if="!xlsFailed"
        class="my-3 flex items-center justify-between space-x-2"
      >
        <div
          class="flex h-1 w-[calc(100%_-_40px)] justify-between rounded-full bg-spring-10"
        >
          <div
            :style="{ width: percentageWidth + '%' }"
            class="h-full rounded-full bg-spring-50"
          ></div>
        </div>
        <div class="text-sm text-n-50">{{ Math.trunc(percentageWidth) }}%</div>
      </div>
      <div v-else class="text-sm text-crimson-40">{{ xlsFailedMessage }}</div>
    </div>

    <div class="mt-5 flex justify-end space-x-2">
      <a
        v-if="completed"
        href="/import/xls/list"
        class="rounded bg-bluecoral py-3 px-7 text-xs font-bold uppercase text-white hover:text-white"
      >
        Proceed
      </a>
      <button
        v-if="xlsFailed"
        class="rounded bg-bluecoral py-3 px-7 text-xs font-bold uppercase text-white hover:text-white"
        @click="retry"
      >
        Retry
      </button>
    </div>
  </div>
  <div
    v-if="!maximize"
    :class="showMinimizedModel ? ' translate-y-0' : ' translate-y-full'"
    class="relative h-[80px] rounded-t-lg bg-eggshell p-6 duration-200"
  >
    <svg-vue
      :class="!maximize ? 'rotate-180' : ''"
      class="absolute right-2.5 top-6 cursor-pointer text-[7px] text-bluecoral duration-200"
      icon="dropdown-arrow"
      @click="maximize = !maximize"
    />
    <div
      v-if="!xlsFailed"
      class="mb-3 mr-2 flex h-1 w-[calc(100%_-_10px)] justify-start rounded-full bg-spring-10"
    >
      <div
        :style="{ width: percentageWidth + '%' }"
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
  <button
    v-if="(totalCount === processedCount || xlsFailed) && !maximize"
    class="absolute bottom-[68px] right-0 translate-x-1/2 -translate-y-1/2 rounded-full bg-white p-[1px]"
    @click="$emit('close')"
  >
    <svg-vue class="text-sm" icon="cross-icon" />
  </button>
  <div
    v-if="!showMinimizedModel"
    class="fixed top-0 right-0 z-[90] h-screen w-screen bg-n-50 opacity-25"
  ></div>
</template>
<script setup lang="ts">
import {
  defineProps,
  watch,
  onMounted,
  defineEmits,
  inject,
  ref,
  computed,
  onUnmounted,
} from 'vue';
import spinnerLoader from './spinnerLoader.vue';
import axios from 'axios';

const currentActivity = ref(null);
const maximize = ref();
const showMinimizedModel = ref(false);

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
  localStorage.getItem('maximize') === 'false'
    ? (maximize.value = false)
    : (maximize.value = true);

  currentActivity.value = mapActivityName(props.activityName);

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

watch(
  () => maximize.value,
  (value) => {
    if (!value) {
      setTimeout(() => (showMinimizedModel.value = true), 260);
    } else {
      showMinimizedModel.value = false;
    }
    localStorage.setItem('maximize', value.toString());
  },
  { deep: true }
);

onUnmounted(() => {
  localStorage.setItem('maximize', '');

  const supportButton: HTMLElement = document.querySelector(
    '#launcher'
  ) as HTMLElement;

  if (supportButton !== null) {
    supportButton.style.transform = 'translatey(0px)';
  }
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
