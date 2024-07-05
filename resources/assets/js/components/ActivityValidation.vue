<template>
  <div class="relative w-[365px] bg-n-10">
    <div class="flex justify-between">
      <h6 class="mb-2 font-bold">Publishing Activity</h6>
      <button
        class="flex items-center gap-1.5 text-xs font-bold text-bluecoral"
        @click="handleMinimize"
      >
        <span>EXPAND</span>
        <svg-vue class="text-[9px]" icon="open-link" />
      </button>
    </div>
    <div class="relative rounded-lg border border-n-20 bg-white p-4">
      <button
        v-if="percentageWidth === 100 || hasError"
        class="absolute right-0 top-0 -translate-y-1/2 translate-x-1/2 rounded-full bg-white p-[1px]"
        @click="stopValidating"
      >
        <svg-vue class="text-sm" icon="cross-icon" />
      </button>
      <div class="flex justify-between">
        <div class="flex space-x-2">
          <div class="text-sm text-n-50">Multiple Activities</div>
          <div
            class="relative mx-2 h-5 w-5 rounded-full bg-spring-10 text-xs font-medium text-spring-50"
          >
            <div
              class="absolute left-1/2 top-1/2 !-translate-y-[40%] -translate-x-[65%]"
            >
              {{ validationNames.length }}
            </div>
          </div>
        </div>
        <button
          v-if="percentageWidth == 100"
          class="text-xs font-bold uppercase text-spring-50"
          @click="startBulkPublish"
        >
          proceed
        </button>
        <button v-else @click="stopValidating">
          <svg-vue
            v-if="!hasError"
            class="mr-1 text-lg text-n-40"
            icon="delete"
          />
        </button>
      </div>
      <div class="flex items-center justify-between space-x-2">
        <div
          class="my-5 mr-2 h-1 w-[283px] justify-start rounded-full bg-spring-10"
          :class="!hasError ? ' ' : '!mb-2 bg-[#E34D5B]'"
        >
          <div
            v-if="!hasError"
            :style="{
              width: (percentageWidth ?? 0) + '%',
            }"
            class="h-full rounded-full bg-spring-50"
          ></div>
        </div>
        <span v-if="!hasError" class="text-sm text-[#344054]"
          >{{
            isNaN(percentageWidth)
              ? 0
              : Math.round(percentageWidth * 100) / 100
          }}%</span
        >
        <span v-else>
          <svg-vue
            class="mr-1 text-[20px] text-[#E34D5B]"
            icon="warning-fill"
          />
        </span>
      </div>
      <div v-if="!hasError">
        <button
          class="flex space-x-2"
          @click="showValidatingList = !showValidatingList"
        >
          <span class="text-sm text-bluecoral">{{
            showValidatingList ? 'Hide details' : 'Show Details'
          }}</span>
          <svg-vue
            class="mr-1 text-[7px] text-bluecoral duration-300"
            :class="showValidatingList ? 'rotate-180' : ''"
            icon="dropdown-arrow"
          />
        </button>
        <ul
          :class="showValidatingList ? 'h-auto  py-2 ' : 'h-0'"
          class="flex flex-col space-y-2 duration-200"
        >
          <li
            v-for="(name, index) in validationNames"
            :key="index"
            class="overflow-x-hidden text-ellipsis whitespace-nowrap text-sm text-n-40 duration-200"
          >
            {{ name ?? '' }}
          </li>
        </ul>
      </div>
      <div v-else>
        <span class="text-sm text-[#E34D5B]">Validation failed</span>
      </div>
    </div>
  </div>
</template>
<script setup lang="ts">
import {
  watch,
  defineProps,
  computed,
  ref,
  onMounted,
  defineEmits,
  watchEffect,
} from 'vue';
import { useStore } from 'Store/activities/index';
import axios from 'axios';

const store = useStore();
const props = defineProps({
  validationStats: {
    type: Object,
    required: true,
  },
  validationNames: {
    type: Array,
    required: true,
  },
  errorTab: {
    type: Boolean,
    required: true,
    default: false,
  },
});

const emit = defineEmits(['stopValidation', 'proceed']);

//setting percentage of validation progressbar , to maintain consistency when page is reloaded or navigated
const showValidatingList = ref(false);
const hasError = ref(false);

//setting data from local storage to vuex ,to preserve state when window is reloaded
onMounted(() => {
  //to check if validation need to be show of not when navigated or refreshed
  let showPopup = Boolean(localStorage.getItem('activityValidating'));
  if (showPopup) {
    store.dispatch('updateStartValidation', true);
  }

  let activitiesIds = localStorage.getItem('validatingActivities');
  if (activitiesIds) {
    store.dispatch('updateValidatingActivities', activitiesIds);
  }
});

watch(
  () => props.errorTab,
  (value) => {
    hasError.value = value;
  }
);

const stopValidating = () => {
  emit('stopValidation');
  axios.get(`/activities/delete-validation-status`).then(() => {
    store.dispatch('updateStartValidation', false);
    store.dispatch('updateValidatingActivities', '');
    localStorage.removeItem('validatingActivities');
    localStorage.removeItem('activityValidating');
  });
};

const startBulkPublish = () => {
  store.dispatch('updateStartValidation', false);
  // localStorage.removeItem('validatingActivities');
  store.dispatch('updateStartBulkPublish', true);
  emit('proceed');
  localStorage.removeItem('activityValidating');
};

const percentageWidth = computed(() => {
  return (
    (props.validationStats.complete
      ? props.validationStats.complete / props.validationStats.total
      : 0) * 100
  );
});

const handleMinimize = () => {
  store.dispatch('updateMinimizeScreen', false);
};

watch(
  () => store.state.bulkActivityPublishStatus.cancelValidationAndPublishing,
  (value) => {
    if (value) {
      stopValidating();
    }
  },
  { deep: true }
);
</script>
