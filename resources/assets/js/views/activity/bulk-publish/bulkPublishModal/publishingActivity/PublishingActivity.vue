<template>
  <div>
    <RollingLoader header="Publishing Activities" />
    <p
      class="mt-2.5 rounded-lg bg-paper p-4 text-sm leading-[22px] tracking-normal text-n-50"
    >
      This process may take some time. You can minimize this tab and continue
      working on other tasks.
    </p>
  </div>
  <div class="mt-6 rounded-lg border border-n-20">
    <div
      class="rounded-t-lg bg-n-10 px-6 py-4 font-bold leading-[18px] tracking-normal text-n-50"
    >
      Activity
    </div>
    {{ store.state.bulkActivityPublishStatus.publishing.response }}
    <ul
      class="space-y-4 divide-y divide-n-20 px-6 pb-4 text-sm leading-[22px] tracking-normal text-n-50"
    >
      <li
        v-for="(value, name, index) in store.state.bulkActivityPublishStatus
          .publishing.activities"
        :key="index"
        class="item flex pt-4"
      >
        <div class="activity-title grow pr-2 text-sm leading-normal text-n-40">
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
        </div>
      </li>
    </ul>
  </div>
</template>

<script setup lang="ts">
import RollingLoader from '../RollingLoaderComponent.vue';
import { useStore } from 'Store/activities/index';

const store = useStore();
</script>

<style scoped></style>
