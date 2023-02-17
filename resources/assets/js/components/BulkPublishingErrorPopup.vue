<template>
  <h3 class="mb-4 text-lg font-medium">
    <svg-vue icon="alert" class="mr-2 inline text-crimson-40"></svg-vue>
    <span class="font-bold">Another Bulk publish in progress</span>
  </h3>
  <div class="fw-bold list-disc rounded-md bg-salmon-10 p-3 font-medium">
    Activities being published:
    <ul class="list-disc rounded-md bg-salmon-10 p-3 font-medium">
      <li
        v-for="(activity, index) in bulkPublishStatus"
        :key="index"
        class="flex justify-between py-2 pr-2"
      >
        <span>{{ activity['activity_title'] }}</span>
        <span
          :class="[
            {
              'text-bluecoral': activity['status'] === 'processing',
              'text-salmon-50': activity['status'] === 'created',
              'text-spring-50': activity['status'] === 'completed',
            },
            'text-bluecoral',
          ]"
        >
          <small>
            {{ activity['status'] }}
          </small>
        </span>
      </li>
    </ul>
    Please wait for previous bulk publish to complete or cancel previous bulk
    publish to continue this bulk publish.
  </div>
</template>

<script lang="ts" setup>
import { onUnmounted, onMounted, inject } from 'vue';

const bulkPublishStatus = inject('bulkPublishStatus');

onMounted(() => {
  document.documentElement.style.overflow = 'hidden';
});

onUnmounted(() => {
  document.documentElement.style.overflow = 'auto';
});
</script>
