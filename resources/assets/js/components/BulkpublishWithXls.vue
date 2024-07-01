<template>
  <div>
    <h3 class="pb-2 text-base font-bold leading-6 text-n-50">Publishing</h3>
    <div class="relative w-full rounded-lg bg-white duration-200">
      <button
        v-if="hasFailedActivities?.ids?.length > 0"
        class="absolute right-0 top-0 -translate-y-1/2 translate-x-1/2 rounded-full bg-white p-[1px]"
        @click="
          () => {
            $emit('close');
          }
        "
      >
        <svg-vue class="text-sm" icon="cross-icon" />
      </button>
      <div class="rounded-lg border border-n-20 bg-white p-4">
        <div class="flex items-center justify-between pb-4">
          <h3 class="flex items-center space-x-2 text-sm text-n-50">
            <span>Multiple Activities </span>
            <span
              class="flex h-6 w-6 items-center justify-center rounded-full bg-lagoon-10 text-lagoon-50"
              >{{
                bulkPublishLength > 0
                  ? bulkPublishLength
                  : store.state.bulkActivityPublishStatus.publishing
                      .activities &&
                    Object.keys(
                      store.state.bulkActivityPublishStatus.publishing
                        .activities
                    ).length
              }}
            </span>
          </h3>
          <button
            class="rounded-full bg-white p-[1px]"
            @click="
              () => {
                $emit('close');
              }
            "
          >
            <svg-vue icon="delete" class="text-sm text-n-40" />
          </button>
        </div>

        <div
          v-if="hasFailedActivities?.ids?.length === 0"
          class="mb-3 flex items-center"
        >
          <div
            class="mr-2 flex h-1 flex-1 justify-start rounded-full bg-spring-10"
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

        <div
          v-if="hasFailedActivities?.ids?.length > 0"
          class="py-2 text-sm font-medium text-crimson-50"
        >
          Some activities have failed to publish.
        </div>

        <div class="flex items-center justify-between">
          <button
            class="space-x-1.5 text-sm leading-[22px] text-blue-50"
            @click="openModel = !openModel"
          >
            <span v-text="!openModel ? 'Show details' : 'Hide details'" />
            <svg-vue
              :class="{ 'rotate-180': openModel }"
              class="cursor-pointer text-[7px] text-bluecoral duration-200"
              icon="dropdown-arrow"
            />
          </button>

          <div
            v-if="hasFailedActivities?.ids?.length > 0"
            class="retry flex cursor-pointer items-center text-crimson-50"
            @click="retryPublishing"
          >
            <svg-vue class="mr-1" icon="redo" />
            <span class="text-xs uppercase">Retry</span>
          </div>
        </div>

        <div v-if="openModel">
          <div
            class="bulk-activities max-h-[240px] overflow-y-auto overflow-x-hidden pt-3 transition-all duration-500"
          >
            <ul class="space-y-3">
              <li
                v-for="(value, name, index) in store.state
                  .bulkActivityPublishStatus.publishing.activities"
                :key="index"
                class="item flex"
              >
                <div
                  class="activity-title grow pr-2 text-sm leading-normal text-n-40"
                >
                  {{ value['activity_title'] }}
                </div>
                <div class="shrink-0 text-xl">
                  <svg-vue
                    v-if="value['status'] === 'completed'"
                    class="text-spring-50"
                    icon="tick"
                  />
                  <svg-vue
                    v-else-if="value['status'] === 'failed'"
                    class="text-crimson-50"
                    icon="times-circle"
                  />
                  <span v-else class="rolling"></span>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup lang="ts">
import { useStorage } from '@vueuse/core';
import {
  onMounted,
  watch,
  computed,
  ref,
  reactive,
  inject,
  defineEmits,
  onUnmounted,
} from 'vue';
import { useStore } from 'Store/activities/index';
import axios from 'axios';
import { isJson } from 'Composable/utils';

const store = useStore();
let pa = useStorage('vue-use-local-storage', {
  publishingActivities: localStorage.getItem('publishingActivities') ?? {},
});

interface actElements {
  activity_id: number;
  activity_title: string;
  status: string;
}

interface RefreshToastMsgTypeface {
  visibility: boolean;
  refreshMessageType: boolean;
  refreshMessage: string;
}

const bulkPublishLength = ref(0);
const openModel = ref(false);
const paStorage = ref({
  publishingActivities: {
    status: {},
    activities: {},
    message: {},
  },
});

const publishingActivities = reactive(
  paStorage.value.publishingActivities?.['activities']
);
const completed = ref();
const emit = defineEmits([
  'close',
  'toggle',
  'activityPublishedData',
  'hideLoader',
]);

let refreshToastMsg = inject('refreshToastMsg') as RefreshToastMsgTypeface;

let hasFailedActivities = reactive({
  data: {} as actElements,
  ids: [] as number[],
  status: false,
});

onMounted(() => {
  setTimeout(() => {
    emit('hideLoader');
  }, 50);

  paStorage.value = store.state.bulkpublishActivities;

  completed.value =
    paStorage?.value?.publishingActivities?.status ?? 'processing';
  bulkPublishStatus();
});

const pollingForBulkpublishData = () => {
  console.log('pollingForBulkpublishData');
  bulkPublishLength.value = store.state.bulkPublishLength;
  const intervalID = setInterval(() => {
    axios.get(`/activities/bulk-publish-status`).then((res) => {
      const response = res.data;

      if (!response.publishing) {
        clearInterval(intervalID);
      }
      if ('data' in response) {
        store.state.bulkActivityPublishStatus.publishing.activities =
          response.data.activities;
        completed.value = response.data.status;
        emit('activityPublishedData', response.data);
        // saving in local storage
        paStorage.value = {
          publishingActivities: {
            activities: response.data.activities,
            status: response.data.status,
            message: response.data.message,
          },
        };

        if (completed.value === 'completed') {
          clearInterval(intervalID);

          failedActivities(paStorage.value.publishingActivities.activities);
          if (hasFailedActivities?.ids?.length > 0) {
            refreshToastMsg.visibility = true;
            refreshToastMsg.refreshMessageType = false;
            refreshToastMsg.refreshMessage =
              'Some activities have failed to publish. Refresh to see changes.';
          } else {
            refreshToastMsg.visibility = true;
            refreshToastMsg.refreshMessage =
              'Activity has been published successfully, refresh to see changes';
            setTimeout(() => {
              refreshToastMsg.visibility = false;
            }, 10000);
          }
        }
      } else {
        completed.value = 'completed';
      }
    });
  }, 3000);
};

const bulkPublishStatus = async () => {
  let count = 0;
  console.log('bulkPublishStatus');
  const checkStatus = setInterval(() => {
    axios.get(`/activities/bulk-publish-status`).then((res) => {
      const response = res.data;
      if ('data' in response) {
        store.state.bulkActivityPublishStatus.publishing.response =
          response.data;
        store.state.bulkActivityPublishStatus.publishing.activities =
          response.data.activities;
        completed.value = response.data.status;
        emit('activityPublishedData', response.data);
        // saving in local storage

        paStorage.value = {
          publishingActivities: {
            activities: response.data.activities,
            status: response.data.status,
            message: response.data.message,
          },
        };

        if (response.data.status !== 'completed') {
          pollingForBulkpublishData();
        }
        clearInterval(checkStatus);
      } else {
        completed.value = 'completed';
      }
    });
    if (count > 5) {
      console.log('count', count);
      clearInterval(checkStatus);
    }

    count++;
  }, 1000);
};

const retryPublishing = () => {
  //reset required states
  completed.value = 'processing';

  for (const key in hasFailedActivities.data) {
    hasFailedActivities.data[key].status = 'processing';
  }

  store.state.bulkActivityPublishStatus.publishing.activities =
    hasFailedActivities.data;

  // api endpoint call
  const endpoint = `/activities/start-bulk-publish?activities=[${hasFailedActivities.ids}]`;
  hasFailedActivities.status = false;
  hasFailedActivities.ids = [];
  hasFailedActivities.data = {} as actElements;

  axios.get(endpoint).then((res) => {
    const response = res.data;

    if (response.success) {
      paStorage.value.publishingActivities = response.data;
      bulkPublishStatus();
    }
  });
};

const failedActivities = (nestedObject: object) => {
  const failedActivitiesID = [] as number[];
  const asArrayData = nestedObject && Object.entries(nestedObject);

  // eslint-disable-next-line @typescript-eslint/no-unused-vars
  const filtered = asArrayData?.filter(([key, value]) => {
    if (value && Object.values(value).indexOf('failed') > -1) {
      failedActivitiesID.push(value.activity_id);
      return key;
    }
  });

  const failedActivitiesData = filtered && Object.fromEntries(filtered);

  if (failedActivitiesID?.length > 0) {
    hasFailedActivities.status = true;
    hasFailedActivities.ids = failedActivitiesID;
    hasFailedActivities.data = failedActivitiesData as actElements;
    refreshToastMsg.refreshMessageType = false;
    refreshToastMsg.refreshMessage =
      'Some activities have failed to publish. Refresh to see changes.';
  } else {
    hasFailedActivities.status = false;
    hasFailedActivities.ids = [];
    hasFailedActivities.data = {} as actElements;
  }
};

const completedActivities = computed(() => {
  let count = 0;
  for (
    let i = 0;
    i <
    (paStorage.value?.publishingActivities?.['activities'] &&
      Object.values(paStorage?.value?.publishingActivities?.['activities'])
        .length);
    i++
  ) {
    if (
      Object.values(
        paStorage?.value?.publishingActivities?.['activities'] as object
      )[i]['status'] === 'completed'
    ) {
      count++;
    }
  }

  return count;
});

const percentageWidth = computed(() => {
  return (
    (completedActivities.value /
      (pa.value?.publishingActivities['activities'] &&
        Object.keys(pa.value?.publishingActivities['activities']).length)) *
    100
  );
});

watch(
  () => [
    store.state.bulkActivityPublishStatus.publishing.activities,
    bulkPublishLength.value,
  ],
  () => {
    if (store.state.bulkActivityPublishStatus.publishing.activities) {
      emit('hideLoader');
    }
  }
);

watch(
  () => store.state.bulkpublishActivities,
  () => {
    setDataToLocalstorage();
    getDataFromLocalstorage();
  }
);
watch(
  () => openModel.value,
  (value) => emit('toggle', value)
);
const getDataFromLocalstorage = () => {
  store.state.bulkActivityPublishStatus.publishing.activities =
    localStorage.getItem('bulkPublishActivities');
  store.state.bulkActivityPublishStatus.publishing.activities =
    isJson(store.state.bulkActivityPublishStatus.publishing.activities) &&
    JSON.parse(store.state.bulkActivityPublishStatus.publishing.activities);
};

const setDataToLocalstorage = () => {
  localStorage.setItem(
    'bulkPublishActivities',
    JSON.stringify(paStorage.value)
  );
};

onUnmounted(() => {
  store.dispatch('updateStartBulkPublish', false);
});

const emptybulkPublishStatus = () => {
  for (const status in publishingActivities) {
    delete publishingActivities[status];
  }
};

watch(
  () => store.state.startBulkPublish,
  (value) => {
    if (value) {
      bulkPublishStatus();
    }
  }
);

watch(
  () => store.state.bulkPublishLength,
  (value) => {
    bulkPublishLength.value = value;
    pa = useStorage('vue-use-local-storage', {
      publishingActivities: localStorage.getItem('publishingActivities') ?? {},
    });
    emptybulkPublishStatus();
    bulkPublishStatus();
    Object.assign(
      publishingActivities,
      pa.value?.publishingActivities['activities']
    );
  },
  { deep: true }
);
</script>
<style lang="scss" scoped>
.minus {
  @apply flex h-3 w-3 items-center;
  &:before {
    content: '';
    @apply block h-0.5 w-3 rounded-xl bg-blue-50;
  }
}

#publishing_activities {
  @apply fixed bottom-0 right-0;
  filter: drop-shadow(0px 4px 40px rgba(0, 0, 0, 0.1));
}

.rolling {
  @apply inline-block animate-spin rounded-full border-2 border-n-20;
  width: 20px;
  height: 20px;
  border-top-color: white;
}

.activity-title {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
</style>
