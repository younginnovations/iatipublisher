<template>
  <div class="min-h-[647px] overflow-hidden bg-white">
    <ErrorMessage></ErrorMessage>
    <div
      id="empty-state"
      class="relative mb-14 flex flex-col items-center duration-300"
    >
      <div class="mb-6">
        <svg-vue icon="folder" class="text-[150px]"></svg-vue>
      </div>
      <h5 class="mb-[5px] text-heading-5 font-bold leading-9">
        No activity has been added yet.
      </h5>
      <div class="mb-[17px] text-caption-c1 leading-5 text-n-50">
        Click on the button below to add a new activity
      </div>
      <ActivityButton :language="language" />
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, reactive } from 'vue';
import ActivityButton from './AddActivityButton.vue';
import ErrorMessage from '../../../components/ErrorMessage.vue';

export default defineComponent({
  name: 'empty-activity',
  components: {
    ActivityButton,
    ErrorMessage,
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
