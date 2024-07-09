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
      <div class="flex justify-between">
        <div class="flex space-x-2">
          <div class="pb-3 text-sm text-n-50" v-if="percentageWidth == 100">
            Data checking complete. Click continue to publish
          </div>
          <div class="text-sm text-n-50" v-else>
            Checking your data before publication
          </div>
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
          v-if="percentageWidth !== 100"
          class="flex items-center text-xs font-bold uppercase text-bluecoral"
        >
          <svg-vue
            v-if="!hasError"
            class="mt-2 fill-bluecoral text-lg text-bluecoral"
            icon="cross"
          />
          <span>Cancel</span>
        </button>
      </div>
      <div class="flex items-center justify-between space-x-2">
        <div
          class="my-2 mr-2 h-1.5 w-[283px] flex-1 justify-start rounded-full bg-[#C4C4C4]"
          :class="!hasError ? ' ' : '!mb-2 bg-[#E34D5B]'"
          v-if="percentageWidth !== 100"
        >
          <div
            v-if="!hasError"
            :style="{
              width: (percentageWidth ?? 0) + '%',
            }"
            class="h-full rounded-full bg-spring-50"
          ></div>
        </div>
        <span v-if="hasError">
          <svg-vue
            class="mr-1 text-[20px] text-[#E34D5B]"
            icon="warning-fill"
          />
        </span>
      </div>
      <div>
        <div
          v-if="percentageWidth === 100"
          class="flex items-start gap-1 border-b border-[#D0DDE0] pt-1 pb-5 text-xs font-bold text-n-50"
        >
          <svg-vue
            icon="warning-activity"
            class="flex-shrink-0 text-base text-[#E34D5B]"
          ></svg-vue>
          <span>
            There may be data quality issues with 24 activities. You can still
            continue to publish
          </span>
        </div>
        <div class="flex justify-center pt-2">
          <div class="flex flex-1 items-center justify-center">
            <button
              v-if="percentageWidth === 100 || hasError"
              class="flex items-center text-xs font-bold uppercase text-bluecoral"
            >
              <svg-vue icon="cross" class="mt-2 text-lg"></svg-vue>
              <span>Cancel</span>
            </button>
          </div>
          <button
            v-if="percentageWidth == 100"
            class="flex flex-1 justify-center rounded border border-bluecoral bg-bluecoral px-3 py-2 text-xs font-bold uppercase text-white"
            @click="startBulkPublish"
          >
            <span>proceed</span>
          </button>
        </div>
      </div>
      <div v-if="hasError">
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
  defineExpose,
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

// const stopValidating = () => {
//   axios.get(`/activities/delete-validation-status`).then(() => {
//     store.dispatch('updateStartValidation', false);
//     store.dispatch('updateValidatingActivities', '');
//     localStorage.removeItem('validatingActivities');
//     localStorage.removeItem('activityValidating');
//   });
// };

// const { refetch: validationCancelHandler } = useQuery({
//   queryKey: ['validationCancelQuery'],
//   queryFn: async () => {
//     return await axios
//       .get(`/activities/delete-validation-status`)
//       .then((res) => {
//         emit('stopValidation');
//         store.dispatch('updateStartValidation', false);
//         store.dispatch('updateValidatingActivities', '');
//         store.state.bulkActivityPublishStatus.publishing.hasFailedActivities = {
//           ...store.state.bulkActivityPublishStatus.publishing
//             .hasFailedActivities,
//           status: false,
//           data: {} as any,
//           ids: [],
//         };
//         localStorage.removeItem('validatingActivities');
//         localStorage.removeItem('activityValidating');
//       })
//       .catch((error) => {
//         console.error(error);
//       });
//   },
//   refetchOnWindowFocus: false,
//   refetchOnMount: false,
//   refetchOnReconnect: false,
//   enabled: false,
// });

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
      // validationCancelHandler();
    }
  }
);

defineExpose({
  // validationCancelHandler,
});
</script>
