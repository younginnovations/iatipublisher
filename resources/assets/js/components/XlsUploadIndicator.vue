<template>
  <div>
    <div
      v-if="
        showBulkpublishLoader ||
        (showBulkpublish && activities && Object.keys(activities).length > 0) ||
        (downloading && !downloadCompleted && !cancelDownload) ||
        (xlsData && showXlsStatus) ||
        showValidationPopup
      "
      ref="parentElementRef"
      :style="minimize ? { bottom: `${-(height - 57)}px` } : {}"
      class="fixed bottom-0 right-5 z-[100] w-[412px] rounded-t-lg bg-n-10 shadow-[0px_2px_12px_0px_rgba(0,0,0,0.12)] transition-all duration-200 ease-linear xl:right-10"
    >
      <div
        class="flex items-center justify-between rounded-t-lg border-b border-n-20 bg-eggshell px-6 py-4"
      >
        {{ store.state.startValidation }}
        {{ store.state.validationRunning }}
        <div class="flex space-x-2">
          <div class="text-base font-bold text-blue-50">Background Tasks</div>
          <div
            class="flex items-center justify-center rounded-full bg-spring-10 px-2 py-1 text-xs text-spring-50"
          >
            <span class="flex font-bold"
              >{{ completeActivityCount }}/
              <ShimmerLoading
                v-if="showBulkpublishLoader"
                class="!mx-1 !h-2.5 !w-3"
              />
              <span v-else>{{ processingActivityCount }}</span>
            </span>
          </div>
        </div>
        <button @click="() => (minimize = !minimize)">
          <svg-vue
            class="h-3 w-3 text-blue-40 duration-300"
            icon="dropdown-arrow"
            :class="{ 'rotate-180': minimize }"
          />
        </button>
      </div>
      <div class="max-h-[600px] space-y-6 overflow-y-scroll p-6">
        <div>
          <ActivityValidation
            v-if="showValidationPopup"
            :validation-stats="
              store.state.bulkActivityPublishStatus.validationStats
            "
            :validation-names="
              store.state.bulkActivityPublishStatus.validationNames
            "
            :error-tab="
              store.state.bulkActivityPublishStatus.showValidationError
            "
            @stop-validation="cancelValidationPolling"
            @proceed="proceedValidation"
          />
          <BulkpublishWithXls
            v-if="
              showBulkpublish &&
              activities &&
              Object.keys(activities).length > 0
            "
            key="bulkpublish"
            @close="closeBulkpublish"
            @activity-published-data="handleActivityPublishedData"
            @hide-loader="hideBulkpublishLoader"
          />
          <BulkpublishLoaderCard v-if="showBulkpublishLoader" />
        </div>

        <ActivityDownload
          v-if="downloading && !downloadCompleted && !cancelDownload"
          key="download"
        />

        <XlsLoader
          v-if="xlsData && showXlsStatus"
          key="xls"
          :total-count="totalCount"
          :processed-count="processedCount"
          :xls-failed="xlsFailed"
          :activity-name="activityName"
          :completed="completed"
          @close="closeXls"
        />
      </div>
    </div>
  </div>
</template>
<script setup lang="ts">
interface activityPublished {
  status: string;
}
import ActivityDownload from './ActivityDownload.vue';
import XlsLoader from './XlsLoader.vue';
import BulkpublishWithXls from './BulkpublishWithXls.vue';
import ActivityValidation from './ActivityValidation.vue';
import BulkpublishLoaderCard from './BulkpublishLoaderCard.vue';

import {
  defineProps,
  ref,
  inject,
  watch,
  onUnmounted,
  onMounted,
  computed,
  Ref,
} from 'vue';
import axios from 'axios';
import { useStore } from 'Store/activities/index';

const store = useStore();
const showXlsStatus = ref(true);

import { useStorage, useElementSize } from '@vueuse/core';
import ShimmerLoading from './ShimmerLoading.vue';

const downloadCompleted = ref(false);

const cancelDownload = ref(false);
const showBulkpublish = ref(true);
const showBulkpublishLoader = ref(false);

const parentElementRef = ref(null);
const { height } = useElementSize(parentElementRef);
const minimize = ref(false);
const publishingActivities = ref<string[]>([]);
const bulkPublishLength = ref(0);
const activityPublishedData = ref() as Ref<activityPublished>;
const downloadStatus = inject('xlsDownloadStatus') as Ref;

const pa = useStorage('vue-use-local-storage', {
  publishingActivities: localStorage.getItem('publishingActivities') ?? {},
});

const props = defineProps({
  activityName: {
    type: String,
    required: false,
    default: '',
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
  xlsData: {
    type: Boolean,
  },
});

onMounted(async () => {
  store.state.bulkActivityPublishStatus.validationNames = (
    store.state.validatingActivitiesNames.length
      ? store.state.validatingActivitiesNames
      : localStorage.getItem('validatingActivitiesNames')?.split('|')
  ) as string[];

  if (!showValidationPopup.value)
    publishingActivities.value =
      pa?.value?.publishingActivities &&
      Object.keys(pa.value.publishingActivities);
  const checkSupportButton = setInterval(() => {
    const supportButton: HTMLElement = document.querySelector(
      '#launcher'
    ) as HTMLElement;

    if (parentElementRef?.value) {
      if (supportButton !== null) {
        minimize?.value
          ? (supportButton.style.transform = 'translatey(-20px)')
          : (supportButton.style.transform = 'translatex(-450px)');

        clearInterval(checkSupportButton);
      }
    }
  }, 10);

  store.dispatch(
    'updateValidatingActivities',
    localStorage.getItem('validatingActivities')
  );
  await checkValidation();
});

const proceedValidation = () => {
  showBulkpublishLoader.value = true;

  cancelValidationPolling();
};

const checkValidation = async () => {
  try {
    const response = await axios.get(
      `/activities/checks-for-activity-bulk-validation`
    );
    if (response.data) {
      const activities = response.data.activities;
      store.state.validationRunning = !response.data.success;

      if (activities) {
        localStorage.setItem(
          'validatingActivitiesNames',
          Object.values(JSON.parse(activities)).join('|')
        );

        const activityId = Object.keys(JSON.parse(activities)).join(',');
        store.dispatch('updateValidatingActivities', activityId);
      }

      if (!response.data.success) {
        checkValidationStatus();
      }
    }
  } catch (error) {
    console.error('Error checking validation:', error);
  }
};

const cancelValidationPolling = () => {
  store.state.validationRunning = false;
};

watch(
  () => [store.state.startBulkPublish, store.state.bulkpublishActivities],
  (value) => {
    if (value) {
      publishingActivities.value =
        store?.state?.bulkpublishActivities?.publishingActivities &&
        Object.keys(store.state.bulkpublishActivities.publishingActivities);

      publishingActivities.value =
        pa?.value?.publishingActivities &&
        Object.keys(pa.value.publishingActivities);
      store.state.validationRunning = false;
      return;
    }
  },
  { deep: true }
);

watch(
  () => store?.state?.startBulkPublish,
  (value) => {
    showBulkpublish.value = value;
  },
  { deep: true }
);
// watch(
//   () => showValidationPopup.value,
//   (value) => {
//     if (value) {
//       showBulkpublish.value = false;
//     }
//   }
// );

const checkValidationStatus = () => {
  const poll = () => {
    axios
      .get(
        `/activities/get-validation-status?activities=[${store.state.validatingActivities}]`
      )
      .then((res) => {
        store.state.bulkActivityPublishStatus.validationStats.complete = 0;
        store.state.bulkActivityPublishStatus.validationStats.total = 0;
        store.state.bulkActivityPublishStatus.validationStats.failed = 0;
        const response = res.data;
        if (response.data && typeof response.data === 'object') {
          store.state.bulkActivityPublishStatus.importedActivitiesList =
            response.data.activities;
          store.state.bulkActivityPublishStatus.validationNames = (
            store.state.validatingActivitiesNames?.length
              ? store.state.validatingActivitiesNames
              : localStorage.getItem('validatingActivitiesNames')?.split('|')
          ) as string[];

          store.state.bulkActivityPublishStatus.validationStats.total =
            response.data.total;
          store.state.bulkActivityPublishStatus.validationStats.complete =
            response.data.complete_count;
          store.state.bulkActivityPublishStatus.validationStats.failed =
            response.data.failed_count;
        }

        if (response.data.status == 'completed') {
          store.state.bulkActivityPublishStatus.iatiValidatorLoader = false; // Assuming you need to set this to false to stop the loader
        } else {
          setTimeout(poll, 3000); // Call poll again after 3 seconds
        }
        store.state.bulkActivityPublishStatus.showValidationError =
          !res.data.success;
      })
      .catch(() => {
        setTimeout(poll, 3000); // Retry after 3 seconds in case of an error
      });
  };

  poll(); // Initial call to start the polling
};

watch(
  () => store.state.startValidation,
  (value) => {
    localStorage.setItem('activityValidating', value ? value.toString() : '');
    if (value) {
      checkValidationStatus();
    }
  },
  { deep: true }
);

watch(
  () => showValidationPopup,
  (value) => {
    if (value) {
      closeBulkpublish();
    }
  }
);

watch(
  () => [store.state.startValidation, store.state.validationRunning],
  () => {
    if (store.state.startValidation || store.state.validationRunning) {
      showBulkpublish.value = false;
    }
  }
);
const showValidationPopup = computed(() => {
  return store.state.startValidation || store.state.validationRunning;
});

onUnmounted(() => {
  const supportButton: HTMLElement = document.querySelector(
    '#launcher'
  ) as HTMLElement;

  if (supportButton !== null) {
    supportButton.style.transform = 'translate(0px ,0px)';
  }
});

const closeBulkpublish = () => {
  showBulkpublish.value = false;
  localStorage.setItem('vue-use-local-storage', 'publishingActivities:{}');
  store.dispatch('updateBulkpublishActivities', {});
  axios.delete(`/activities/delete-bulk-publish-status`);
};

const closeXls = () => {
  showXlsStatus.value = false;
  axios.delete(`/import/xls`).then(() => {
    store.dispatch('updateCancelUpload', true);
    store.dispatch('updateCloseXlsModel', true);
    setTimeout(() => store.dispatch('updateCloseXlsModel', false), 2000);
  });
};

watch(
  () => store.state.completeXlsDownload,
  (value) => {
    if (value) {
      downloadCompleted.value = true;
    }
    downloadCompleted.value = false;
  },
  { deep: true }
);
watch(
  () => store.state.bulkPublishLength,
  (value) => {
    bulkPublishLength.value = value;
  },
  { deep: true }
);

watch(
  () => store.state.cancelDownload,
  (value) => {
    cancelDownload.value = value;
  },
  { deep: true }
);

watch(
  () => parentElementRef.value,
  (value) => {
    if (value == null) {
      const checkSupportButton = setInterval(() => {
        const supportButton: HTMLElement = document.querySelector(
          '#launcher'
        ) as HTMLElement;

        if (supportButton !== null) {
          supportButton.style.transform = 'translatey(0px)';

          clearInterval(checkSupportButton);
        }
      }, 10);
    }
  },
  { deep: true }
);

watch(
  () => minimize.value,
  (value) => {
    const checkSupportButton = setInterval(() => {
      const supportButton: HTMLElement = document.querySelector(
        '#launcher'
      ) as HTMLElement;
      if (parentElementRef.value) {
        if (supportButton !== null) {
          value
            ? (supportButton.style.transform = 'translatey(-20px)')
            : (supportButton.style.transform = 'translatex(-450px)');

          clearInterval(checkSupportButton);
        }
      }
    }, 10);
  }
);

const downloading = inject('downloading') as Ref;
const activities = inject('activities') as Ref;

const processingActivityCount = computed(() => {
  let count = 0;
  if (
    showBulkpublish?.value &&
    activities?.value &&
    Object.keys(activities?.value).length > 0
  ) {
    count++;
  }
  if (
    downloading?.value &&
    !downloadCompleted?.value &&
    !cancelDownload?.value
  ) {
    count++;
  }
  if (props.xlsData && showXlsStatus?.value) {
    count++;
  }
  if (showValidationPopup.value) {
    count++;
  }

  if (count > 0) {
    const supportButton: HTMLElement = document.querySelector(
      '#launcher'
    ) as HTMLElement;
    if (supportButton !== null) {
      minimize?.value
        ? (supportButton.style.transform = 'translatey(-20px)')
        : (supportButton.style.transform = 'translatex(-450px)');
    }
  }
  return count;
});

const completeActivityCount = computed(() => {
  let count = 0;
  if (
    activityPublishedData?.value?.status === 'completed' &&
    showBulkpublish.value
  ) {
    count++;
  }

  if (downloadStatus?.value == 'completed') {
    count++;
  }

  if (props.completed) {
    count++;
  }
  if (
    showValidationPopup?.value &&
    (store.state.bulkActivityPublishStatus.validationStats.complete ===
      store.state.validatingActivitiesNames.length ||
      store.state.bulkActivityPublishStatus.validationStats.complete ===
        localStorage.getItem('validatingActivitiesNames')?.split('|').length)
  ) {
    count++;
  }

  return count;
});
const hideBulkpublishLoader = () => {
  showBulkpublishLoader.value = false;
};

const handleActivityPublishedData = (data) => {
  activityPublishedData.value = data;
};
</script>
