<template>
  <div
    :class="!openModel ? 'h-[80px]' : ''"
    class="relative w-[300px] duration-200"
  >
    <button
      class="absolute top-0 right-0 translate-x-1/2 -translate-y-1/2 rounded-full bg-white p-[1px]"
      @click="
        () => {
          $emit('close');
        }
      "
    >
      <svg-vue icon="cross-icon" class="text-sm" />
    </button>

    <svg-vue
      :class="{ 'rotate-180': !openModel, '': openModel }"
      class="absolute right-2.5 top-6 cursor-pointer text-[7px] text-bluecoral duration-200"
      icon="dropdown-arrow"
      @click="openModel = !openModel"
    />
    <div v-if="!openModel" class="rounded-t-lg bg-eggshell p-6">
      <div class="mb-3 mr-2 flex h-1 justify-start rounded-full bg-spring-10">
        <div
          :style="{ width: percentageWidth + '%' }"
          class="h-full rounded-full bg-spring-50"
        ></div>
      </div>
      <div class="text-sm text-n-40">
        Publishing
        <span v-if="activities"
          >{{ completedActivities }}/{{ Object.keys(activities).length }}</span
        >
        activities to IATI registry
      </div>
    </div>
    <div v-else class="rounded-t-lg bg-white">
      <div
        class="flex justify-between rounded-t-lg bg-eggshell py-4 px-6 text-sm font-bold"
      >
        <h6>
          Publishing

          {{ bulkPublishLength != 0 ? bulkPublishLength : '' }} activities
        </h6>
        <div
          v-if="hasFailedActivities?.ids?.length > 0"
          class="retry mr-2 flex cursor-pointer items-center text-crimson-50"
          @click="retryPublishing"
        >
          <svg-vue class="mr-1" icon="redo" />
          <span class="text-xs uppercase">Retry</span>
        </div>
      </div>
      <div
        class="bulk-activities max-h-[240px] overflow-y-auto overflow-x-hidden py-2 px-6 transition-all duration-500"
      >
        <div>
          <div
            v-for="(value, name, index) in activities"
            :key="index"
            class="item flex py-3"
          >
            <div class="activity-title grow pr-2 text-sm leading-normal">
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
  onUpdated,
  onUnmounted,
} from 'vue';
import { useStore } from 'Store/activities/index';
import axios from 'axios';
const store = useStore();
let pa = useStorage('vue-use-local-storage', {
  publishingActivities: localStorage.getItem('publishingActivities') ?? {},
});

interface paInterface {
  value: {
    publishingActivities: paElements;
  };
}

interface paElements {
  activities: actElements;
  organization_id: number;
  job_batch_uuid: string;
  status: string;
  message: string;
}

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
let paStorage = ref(store.state.bulkpublishActivities);

const publishingActivities = reactive(
  paStorage.value.publishingActivities['activities']
);
const completed = ref();
const emit = defineEmits(['close']);

//inject

let refreshToastMsg = inject('refreshToastMsg') as RefreshToastMsgTypeface;

let intervalID;
// let activities = ref(paStorage.value.publishingActivities.activities);
let activities = ref();

let hasFailedActivities = reactive({
  data: {} as actElements,
  ids: [] as number[],
  status: false,
});
const bulkPublishStatus = () => {
  intervalID = setInterval(() => {
    axios.get(`/activities/bulk-publish-status`).then((res) => {
      const response = res.data;
      if (!response.publishing) {
        clearInterval(intervalID);
      }
      if ('data' in response) {
        activities.value = response.data.activities;
        completed.value = response.data.status;

        // saving in local storage
        paStorage.value.publishingActivities.activities =
          response.data.activities;
        paStorage.value.publishingActivities.status = response.data.status;
        paStorage.value.publishingActivities.message = response.data.message;
        if (completed.value === 'completed') {
          clearInterval(intervalID);

          failedActivities(paStorage.value.publishingActivities.activities);
          refreshToastMsg.visibility = true;
          setTimeout(() => {
            refreshToastMsg.visibility = false;
          }, 10000);
        }
      } else {
        completed.value = 'completed';
      }
    });
  }, 2000);
};

const retryPublishing = () => {
  //reset required states
  completed.value = 'processing';

  for (const key in hasFailedActivities.data) {
    hasFailedActivities.data[key].status = 'processing';
  }

  activities.value = hasFailedActivities.data;

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

const failedActivities = (nestedObject: actElements) => {
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

const totalActivites = computed(() => {
  return (
    pa.value?.publishingActivities['activities'] &&
    Object.keys(pa.value?.publishingActivities['activities']).length
  );
});

const completedActivities = computed(() => {
  let count = 0;
  for (
    let i = 0;
    i <
    (paStorage.value?.publishingActivities['activities'] &&
      Object.values(paStorage.value?.publishingActivities['activities'])
        .length);
    i++
  ) {
    if (
      Object.values(
        paStorage.value.publishingActivities['activities'] as object
      )[i]['status'] === 'completed'
    ) {
      count++;
    }
  }

  return count;
});

// const retryPublishing = () => {
//   //reset required states
//   completed.value = 'processing';

//   for (const key in hasFailedActivities.data) {
//     hasFailedActivities.data[key].status = 'processing';
//   }

//   activities.value = hasFailedActivities.data;

//   // api endpoint call
//   const endpoint = `activities/start-bulk-publish?activities=[${hasFailedActivities.ids}]`;

//   axios.get(endpoint).then((res) => {
//     const response = res.data;

//     if (response.success) {
//       paStorage.value.publishingActivities = response.data;
//       bulkPublishStatus();
//     }
//   });
// };

const percentageWidth = computed(() => {
  return (
    (completedActivities.value /
      (pa.value?.publishingActivities['activities'] &&
        Object.keys(pa.value?.publishingActivities['activities']).length)) *
    100
  );
});
watch(
  () => store.state.bulkpublishActivities,
  () => {
    setDataToLocalstorage();
    getDataFromLocalstorage();
  }
);
const getDataFromLocalstorage = () => {
  activities.value = localStorage.getItem('bulkPublishActivities');
  activities.value = JSON.parse(activities.value);
};

const setDataToLocalstorage = () => {
  localStorage.setItem(
    'bulkPublishActivities',
    JSON.stringify(paStorage.value)
  );
};

onMounted(() => {
  completed.value = paStorage.value.publishingActivities.status ?? 'processing';
  bulkPublishStatus();
});
onUnmounted(() => {
  store.dispatch('updateStartBulkPublish', false);
});

const emptybulkPublishStatus = () => {
  for (const status in publishingActivities) {
    delete publishingActivities[status];
  }
};

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
