<template>
  <div class="rounded-lg bg-white p-6 text-xs leading-relaxed text-n-40">
    <div class="mb-3">Note</div>
    <div class="mb-3 flex justify-between">
      <div class="flex items-center space-x-1">
        <svg-vue class="text-sm" icon="core" />
        <span>Core Elements</span>
      </div>
      <HoverText
        hover-text="You cannot publish an activity until all the mandatory fields have been filled."
        name=""
      />
    </div>

    <div class="mb-3 flex justify-between">
      <div class="flex items-center space-x-1">
        <svg-vue class="text-sm" icon="star" />
        <span>Mandatory sub-elements</span>
      </div>
      <HoverText
        hover-text="You cannot publish an activity until all the mandatory fields have been filled."
        name=""
      />
    </div>

    <div class="mb-3 flex justify-between">
      <div class="flex items-center space-x-1">
        <svg-vue class="text-sm" icon="moon" />
        <span>Recommended sub-elements</span>
      </div>
      <HoverText
        hover-text="You cannot publish an activity until all the mandatory fields have been filled."
        name=""
      />
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import HoverText from '../../../components/HoverText.vue';

export default defineComponent({
  name: 'ElementNote',
  components: {
    HoverText,
  },
  props: {},
  setup() {
    return {};
  },
});
</script>
