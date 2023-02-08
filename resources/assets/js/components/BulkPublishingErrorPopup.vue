<template>
  <h3 class="mb-4 text-lg font-medium">
    <svg-vue icon="alert" class="mr-2 inline text-crimson-40"></svg-vue>
    <span class="font-bold">Another Bulk publish in progress</span>
  </h3>
  <div class="fw-bold list-disc rounded-md bg-salmon-10 p-3 font-medium">
    Activities being published:
    <ul class="list-disc rounded-md bg-salmon-10 p-3 font-medium">
      <li
        v-for="(activity, index) in message"
        :key="index"
        class="flex justify-between py-2 pr-2"
      >
        <span>{{ activity.activity_title }}</span>
        <span :class="getActivityClass(activity.status)">
          <small>
            {{ activity.status }}
          </small>
        </span>
      </li>
    </ul>
    Please wait for previous bulk publish to complete or cancel previous bulk
    publish to continue this bulk publish.
  </div>
</template>

<script lang="ts">
import { defineComponent, onMounted, onUnmounted, ref } from 'vue';
import axios from 'axios';

export default defineComponent({
  name: 'BulkPublishingErrorPopup',
  components: {},

  setup() {
    const message = ref('');

    onMounted(() => {
      document.documentElement.style.overflow = 'hidden';

      axios.get('activities/organisation-bulk-publish-status').then((res) => {
        const response = res.data;
        message.value = response.data.activities;
      });
    });

    onUnmounted(() => {
      document.documentElement.style.overflow = 'auto';
    });

    const getActivityClass = (status) => {
      if (status === 'processing') {
        return 'text-bluecoral';
      } else if (status === 'created') {
        return 'text-salmon-50';
      } else if (status === 'completed') {
        return 'text-spring-50';
      } else {
        return 'text-crimson-50';
      }
    };

    return {
      message,
      getActivityClass,
    };
  },
});
</script>
