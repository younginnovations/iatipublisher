<template>
  <div
    class="fixed right-10 bottom-0 inline-flex rounded-t-lg bg-eggshell py-4 px-8 text-sm leading-normal text-n-50"
  >
    <span>5 activities ready to publish</span>
    <span class="ml-2.5 cursor-pointer font-bold text-spring-50"
      >Publish all</span
    >
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'toast-message',
  components: {},
  setup() {
    return {};
  },
});
</script>
