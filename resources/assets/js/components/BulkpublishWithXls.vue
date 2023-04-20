<template>
  <div
    v-if="
      bulkPublishLength > 0 || Object.keys(pa.publishingActivities).length > 0
    "
    class="relative h-[80px] w-[300px] rounded-t-lg bg-eggshell p-6"
  >
    <svg-vue
      class="absolute right-2 top-6 cursor-pointer text-[7px] text-bluecoral"
      icon="dropdown-arrow"
      @click="openModel = !openModel"
    />
    <div v-if="!openModel">
      <div class="mb-3 flex h-1 w-full justify-start rounded-full bg-spring-10">
        <div
          :style="{ width: percentageWidth + '%' }"
          class="h-full rounded-full bg-spring-50"
        ></div>
      </div>
      <div class="text-sm text-n-40">
        Publishing {{ completedActivities }}/{{
          Object.keys(pa.publishingActivities['activities']).length
        }}
        activities to IATI registry
      </div>
    </div>
    <div v-else>
      <h6 class="text-sm font-bold">
        Publishing
        {{
          pa.publishingActivities != 0
            ? Object.keys(pa.publishingActivities).length
            : ''
        }}
        {{ bulkPublishLength != 0 ? bulkPublishLength : '' }} activities
      </h6>
    </div>
  </div>
</template>
<script setup lang="ts">
import { useStorage } from '@vueuse/core';
import { onMounted, watch, computed, ref } from 'vue';
import { useStore } from 'Store/activities/index';
const store = useStore();

const pa = useStorage('vue-use-local-storage', {
  publishingActivities: localStorage.getItem('publishingActivities') ?? {},
});
const bulkPublishLength = ref(0);
const openModel = ref(false);

const completedActivities = computed(() => {
  let count = 0;
  for (
    let i = 0;
    i < Object.values(pa.value.publishingActivities['activities']).length;
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
      Object.keys(pa.value.publishingActivities['activities']).length) *
    100
  );
});

onMounted(() => {
  console.log(
    completedActivities.value,
    Object.keys(pa.value.publishingActivities['activities']).length,
    percentageWidth.value
  );
});

watch(
  () => store.state.bulkPublishLength,
  (value) => {
    bulkPublishLength.value = value;
  },
  { deep: true }
);
</script>
