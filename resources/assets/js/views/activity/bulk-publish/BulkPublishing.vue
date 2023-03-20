<template>
  <div
    id="publishing_activities"
    :class="isLoading && 'hidden'"
    class="z-50 w-[366px]"
  >
    <div class="bulk-head flex items-center justify-between bg-eggshell p-4">
      <div class="grow text-sm font-bold leading-normal">
        Publishing {{ Object.keys(activities).length }} activities
      </div>
      <div class="flex shrink-0">
        <div
          v-if="hasFailedActivities.ids.length > 0"
          class="retry flex cursor-pointer items-center text-crimson-50"
          @click="retryPublishing"
        >
          <svg-vue class="mr-1" icon="redo" />
          <span class="text-xs uppercase">Retry</span>
        </div>
        <div v-else class="minus cursor-pointer" @click="toggleWindow"></div>
        <div
          v-if="completed === 'completed'"
          class="cross cursor-pointer"
          @click="closeWindow"
        ></div>
      </div>
    </div>
    <div
      class="bulk-activities max-h-[240px] overflow-y-auto overflow-x-hidden bg-white transition-all duration-500"
    >
      <div>
        <div
          v-for="(value, name, index) in activities"
          :key="index"
          class="item flex px-4 py-3"
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
</template>
<script setup lang="ts">
import { onMounted, ref, reactive, watch, inject, onUnmounted } from 'vue';
import axios from 'axios';
import { detailStore } from 'Store/activities/show';

const store = detailStore();

const isLoading = ref(false);

interface RefreshToastMsgTypeface {
  visibility: boolean;
  refreshMessageType: boolean;
  refreshMessage: string;
}

let refreshToastMsg = inject('refreshToastMsg') as RefreshToastMsgTypeface;

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

//inject
let paStorage = inject('paStorage') as paInterface;

let activities = ref(paStorage.value.publishingActivities.activities),
  completed = ref('processing');

let hasFailedActivities = reactive({
  data: {} as actElements,
  ids: [] as number[],
  status: false,
});

let intervalID;

/**
 *   Component lifecycle - onMounted
 */
onMounted(() => {
  completed.value = paStorage.value.publishingActivities.status ?? 'processing';
  bulkPublishStatus();
  setTimeout(() => {
    const supportButton: HTMLElement = document.querySelector(
      '#launcher'
    ) as HTMLElement;
    if (supportButton !== null) {
      supportButton.style.transform = 'translateX(-350px)';
    }
    console.log(supportButton);
  }, 680);
  // const supportButton: HTMLElement = document.querySelector(
  //   '#launcher'
  // ) as HTMLElement;
});
onUnmounted(() => {
  const supportButton: HTMLElement = document.querySelector(
    '#launcher'
  ) as HTMLElement;
  if (supportButton !== null) {
    supportButton.style.transform = 'translateX(0px)';
  }
}),
  // watching change in value of completed
  watch(completed, async (newValue) => {
    if (newValue === 'completed') {
      clearInterval(intervalID);

      // resetting local storage
      // paStorage.value.publishingActivities = {} as paElements;

      // check for failed publish
      failedActivities(paStorage.value.publishingActivities.activities);
    }
  });
watch(
  () => store.state.isLoading,
  (value) => {
    isLoading.value = value;
  }
);
const checkBulkpublishStatus = () => {
  for (let key in activities.value) {
    const activity = activities.value[key];

    let url = `activities/queue-status?activity_id=${activity.activity_id}&&uuid=${paStorage.value.publishingActivities.job_batch_uuid}`;

    axios.get(url).then((response) => {
      paStorage.value.publishingActivities.status = response.data.message;
    });
  }
};

/**
 * Bulk Publish Function
 */
const bulkPublishStatus = () => {
  let count = 0;
  intervalID = setInterval(() => {
    axios
      .get(
        `activities/bulk-publish-status?organization_id=${paStorage.value.publishingActivities.organization_id}&&uuid=${paStorage.value.publishingActivities.job_batch_uuid}`
      )
      .then((res) => {
        const response = res.data;
        if ('data' in response) {
          activities.value = response.data.activities;
          completed.value = response.data.status;

          // saving in local storage
          paStorage.value.publishingActivities.activities =
            response.data.activities;
          paStorage.value.publishingActivities.status = response.data.status;
          paStorage.value.publishingActivities.message = response.data.message;

          if (completed.value === 'completed') {
            count = 0;
            failedActivities(paStorage.value.publishingActivities.activities);
            refreshToastMsg.visibility = true;
            setTimeout(() => {
              refreshToastMsg.visibility = false;
            }, 10000);
          }
        } else {
          completed.value = 'completed';
        }
        if (completed.value === 'processing') {
          count++;
          if (count > 30) {
            clearInterval(intervalID);
          }
        }
      });
  }, 2000);

  if (paStorage.value.publishingActivities.status === 'processing') {
    console.log('checking satus');
    checkBulkpublishStatus();
  }
};

/**
 * Minimize or maximize window
 */
const open = ref(true);
const toggleWindow = (e: Event) => {
  const currentTarget = e.currentTarget as HTMLElement;
  const target = (
    currentTarget.closest('#publishing_activities') as HTMLElement
  ).querySelector<HTMLElement>('.bulk-activities');
  const elHeight = target?.querySelector('div')?.clientHeight;

  if (open.value) {
    if (target != null) {
      target.style.cssText = `height: ${elHeight}px;`;
      setTimeout(function () {
        target.style.cssText = `height: 0px; overflow: hidden;`;
      }, 100);
      open.value = false;
    }
  } else {
    if (target != null) {
      target.style.cssText = `height: ${elHeight}px; overflow:hidden;`;

      setTimeout(function () {
        target.style.cssText = `height: auto;`;
      }, 600);

      open.value = true;
    }
  }
};

/**
 * Closing window
 */
const closeWindow = () => {
  paStorage.value.publishingActivities = {} as paElements;
};

/**
 * Function to collect failed activities
 */

const failedActivities = (nestedObject: actElements) => {
  const failedActivitiesID = [] as number[];
  const asArrayData = Object.entries(nestedObject);

  // eslint-disable-next-line @typescript-eslint/no-unused-vars
  const filtered = asArrayData.filter(([key, value]) => {
    if (Object.values(value).indexOf('failed') > -1) {
      failedActivitiesID.push(value.activity_id);
      return key;
    }
  });

  const failedActivitiesData = Object.fromEntries(filtered);

  if (failedActivitiesID.length > 0) {
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

/**
 * Retry publishing failed activities
 */
const retryPublishing = () => {
  //reset required states
  completed.value = 'processing';

  for (const key in hasFailedActivities.data) {
    hasFailedActivities.data[key].status = 'processing';
  }

  activities.value = hasFailedActivities.data;

  // api endpoint call
  const endpoint = `activities/start-bulk-publish?activities=[${hasFailedActivities.ids}]`;

  axios.get(endpoint).then((res) => {
    const response = res.data;

    if (response.success) {
      paStorage.value.publishingActivities = response.data;
      bulkPublishStatus();
    }
  });
};
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

.cross {
  @apply relative ml-5 h-3 w-3 overflow-hidden;

  &:before,
  &:after {
    content: '';
    @apply absolute left-1/2 top-0 block h-3 w-0.5 -translate-x-1/2 rounded-xl bg-blue-50;
  }

  &:before {
    @apply rotate-45;
  }

  &:after {
    @apply -rotate-45;
  }
}

.activity-title {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
</style>
