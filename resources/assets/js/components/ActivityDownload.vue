<template>
  <div class="h-[80px] rounded-t-lg bg-eggshell p-6">
    <div class="mb-3 flex h-1 w-full justify-start rounded-full bg-spring-10">
      <div
        :style="{ width: percentageWidth + '%' }"
        class="h-full rounded-full bg-spring-50"
      ></div>
    </div>

    <div class="flex justify-between space-x-5">
      <p v-if="fileCount != 4" class="text-sm text-n-40">
        Preparing {{ fileCount ? fileCount : 0 }}/4 activities for download
      </p>
      <p v-else class="text-sm text-n-40">Download Ready</p>

      <spinnerLoader v-if="fileCount != 4" />
      <div
        v-else
        class="text-xs font-bold uppercase text-spring-50 hover:text-spring-50"
      >
        download
      </div>
    </div>
  </div>
</template>
<script setup lang="ts">
import { inject, computed, onMounted, onUnmounted } from 'vue';
import spinnerLoader from './spinnerLoader.vue';

onMounted(() => {
  const supportButton: HTMLElement = document.querySelector(
    '#launcher'
  ) as HTMLElement;

  if (supportButton !== null) {
    supportButton.style.transform = 'translatey(-50px)';
  }
});

onUnmounted(() => {
  const supportButton: HTMLElement = document.querySelector(
    '#launcher'
  ) as HTMLElement;

  if (supportButton !== null) {
    supportButton.style.transform = 'translatey(0px)';
  }
});
const percentageWidth = computed(() => {
  return (4 / 4) * 100;
});

const fileCount = inject('fileCount');
</script>
