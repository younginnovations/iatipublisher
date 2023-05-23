<template>
  <div
    :class="
      maximize
        ? 'bottom-1/2 right-1/2 translate-y-1/2 translate-x-1/2 p-6'
        : ' bottom-0 right-10 translate-y-full'
    "
    class="!fixed z-[100] bg-white duration-300"
  >
    <h6 v-if="maximize" class="mb-5 font-bold">Upload in progess</h6>
    <div
      :class="maximize && 'p-6'"
      class="relative h-[80px] rounded-lg border border-n-20 duration-200"
    >
      <div
        v-if="!xlsFailed"
        class="mb-3 mr-2 flex h-1 w-[calc(100%_-_10px)] justify-start rounded-full bg-spring-10"
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
          v-if="
            (totalCount === processedCount && totalCount !== 0) || completed
          "
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
          v-if="
            (processedCount !== totalCount || totalCount === 0) && !completed
          "
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
    <div v-if="maximize" class="mt-5 flex justify-end space-x-3">
      <button
        class="text-xs font-bold uppercase text-bluecoral"
        @click="$emit('close')"
      >
        cancel
      </button>
      <BtnComponent
        class="!border-red h-10 !border"
        type="primary"
        text="Minimize"
        @click="maximize = !maximize"
      />
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
        v-if="totalCount === processedCount || completed"
        class="text-sm text-n-40"
      >
        {{ currentActivity }} file upload complete
      </p>
      <p v-else class="text-sm text-n-40">
        Uploading
        <span v-if="totalCount">
          {{ `${processedCount} / ${totalCount}` }}</span
        >
        '{{ currentActivity }}'
      </p>
      <spinnerLoader v-if="!completed" />
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
    v-if="totalCount === processedCount || xlsFailed"
    class="absolute right-0 bottom-[80px] translate-x-4 rounded-full bg-white p-[1px]"
    @click="$emit('close')"
  >
    <svg-vue icon="cross-icon" />
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
  onUpdated,
  inject,
  ref,
  computed,
  onUnmounted,
} from 'vue';
import spinnerLoader from './spinnerLoader.vue';
import axios from 'axios';
import BtnComponent from 'Components/ButtonComponent.vue';

const currentActivity = ref(null);
const maximize = ref(true);
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
watch(
  () => maximize.value,
  (value) => {
    if (!value) {
      setTimeout(() => (showMinimizedModel.value = true), 260);
    } else {
      showMinimizedModel.value = false;
    }
  },
  { deep: true }
);

onUnmounted(() => {
  const supportButton: HTMLElement = document.querySelector(
    '#launcher'
  ) as HTMLElement;

  if (supportButton !== null) {
    supportButton.style.transform = 'translatey(0px)';
  }
});

const percentageWidth = computed(() => {
  console.log('width');
  if (props.totalCount !== 0) {
    return (props.processedCount / props.totalCount) * 100;
  } else if (props.completed) {
    console.log('completed');
    return 100;
  } else {
    return 0;
  }
});

const xlsFailedMessage = inject('xlsFailedMessage');
</script>
