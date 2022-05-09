<template>
  <div
    id="empty-state"
    class="relative flex min-h-[647px] flex-col items-center justify-center bg-white p-10"
  >
    <div
      v-if="state.dismiss"
      class="absolute left-0 top-0 flex w-full rounded-bl rounded-br bg-rose py-4 px-5 text-sm leading-relaxed text-n-50"
    >
      <div class="grow">
        <div class="flex items-center">
          <svg-vue
            icon="alert"
            class="mr-1 grow-0 text-base text-crimson-50"
          ></svg-vue>
          <p class="grow">
            Please <a href="#" class="font-bold">complete your setup</a> in
            order to enable complete features of IATI publisher tool.
          </p>
        </div>
      </div>
      <div class="grow-0">
        <button
          class="text-sm leading-relaxed text-bluecoral"
          @click="state.dismiss = false"
        >
          Dismiss
        </button>
      </div>
    </div>
    <div
      class="mb-6 flex h-[150px] w-[150px] items-center justify-center rounded-full"
      style="background: linear-gradient(180deg, #e3ecfa 0%, #dae7ff 100%)"
    >
      <svg-vue icon="folder" class="text-[94px]"></svg-vue>
    </div>
    <h5 class="mb-[5px] text-heading-5 font-bold leading-9">
      No activity has been added yet.
    </h5>
    <div class="mb-[17px] text-caption-c1 leading-5 text-n-50">
      Click on the button below to add a new activity
    </div>
    <ActivityButton :language="language" />
  </div>
</template>

<script lang="ts">
import { defineComponent, reactive } from 'vue';
import ActivityButton from './AddActivityButton.vue';
import { useToggle } from '@vueuse/core';

export default defineComponent({
  name: 'empty-activity',
  components: {
    ActivityButton,
  },
  props: {
    language: {
      type: [String, Object],
      required: true,
    },
  },
  setup(props) {
    const state = reactive({
      dismiss: true,
    });

    return { state, props };
  },
});
</script>
