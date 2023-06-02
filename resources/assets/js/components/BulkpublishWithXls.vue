<template>
  <div
    v-if="
      bulkPublishLength > 0 || Object.keys(pa.publishingActivities).length > 0
    "
    :class="!openModel ? 'h-[80px]' : ''"
    class="relative w-[300px] rounded-t-lg duration-200"
  >
    <svg-vue
      class="absolute right-0 top-0 translate-x-1/2 -translate-y-1/2 cursor-pointer rounded-full bg-white p-[1px] text-sm"
      icon="cross-icon"
      @click="closeWindow"
    />

    <svg-vue
      :class="!openModel ? 'rotate-180' : ''"
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
        Publishing {{ completedActivities }}/{{
          publishingActivities && Object.keys(publishingActivities).length
        }}
        activities to IATI registry
      </div>
    </div>
    <div v-else class="rounded-t-lg bg-white">
      <h6 class="bg-eggshell py-4 px-6 text-sm font-bold">
        Publishing

        {{ bulkPublishLength != 0 ? bulkPublishLength : '' }} activities
      </h6>
      <div
        class="bulk-activities max-h-[240px] overflow-y-auto overflow-x-hidden py-2 px-6 transition-all duration-500"
      >
        <div>
          <div
            v-for="(value, name, index) in publishingActivities"
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
import { onMounted, watch, computed, ref, reactive } from 'vue';
import { useStore } from 'Store/activities/index';
import axios from 'axios';

const store = useStore();
let pa = useStorage('vue-use-local-storage', {
  publishingActivities: localStorage.getItem('publishingActivities') ?? {},
});
const bulkPublishLength = ref(0);
const openModel = ref(false);
const publishingActivities = reactive(
  pa.value.publishingActivities['activities']
);

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
    (pa.value?.publishingActivities['activities'] &&
      Object.values(pa.value?.publishingActivities['activities']).length);
    i++
  ) {
    // console.log(
    //   (Object.values(pa.value.publishingActivities['activities']) as object)[i][
    //     'status'
    //   ],
    //   'computed'
    // );
    if (
      Object.values(pa.value.publishingActivities['activities'] as object)[i][
        'status'
      ] === 'completed'
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

onMounted(() => {
  console.log(pa, 'pa');
});
const closeWindow = () => {
  pa.value.publishingActivities = {};
  // emit('close');
  axios.delete(`activities/delete-bulk-publish-status`);
};

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
