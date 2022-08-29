<template>
  <div
    id="empty-state"
    class="relative flex min-h-[647px] flex-col items-center justify-center bg-white p-10"
  >
    <div
      class="mb-6 flex h-[150px] w-[150px] items-center justify-center rounded-full"
      style="background: linear-gradient(180deg, #e3ecfa 0%, #dae7ff 100%)"
    >
      <svg-vue icon="folder" class="text-[94px]" />
    </div>
    <h5 class="mb-[5px] text-heading-5 font-bold leading-9">
      No activity has been added yet.
    </h5>
    <div class="mb-[17px] text-caption-c1 leading-5 text-n-50">
      Click on the button below to add a new activity
    </div>
    <ActivityButton />
  </div>
</template>

<script lang="ts">
import { defineComponent, reactive } from 'vue';
import ActivityButton from './AddActivityButton.vue';

export default defineComponent({
  name: 'EmptyActivity',
  components: {
    ActivityButton,
  },
  setup() {
    const state = reactive({
      dismiss: true,
    });

    return { state };
  },
});
</script>
