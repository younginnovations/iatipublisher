<template>
  <div class="inline-flex items-center align-middle">
    <svg-vue icon="warning-orange" />
    <span class="missing-text">{{ item }} {{ missing }}</span>
  </div>
</template>
<script setup lang="ts">
import { capitalize, defineProps } from 'vue';

const props = defineProps({
  // eslint-disable-next-line vue/require-default-prop
  item: {
    type: String,
    required: false,
  },
});

let missing = 'missing';

if (!props.item) {
  missing = capitalize(missing);
}
</script>
<style>
.missing-text {
  font-family: Arial, sans-serif;
  font-size: 12px;
  font-weight: 400;
  line-height: 20px;
  letter-spacing: -0.02em;
  text-align: left;
  @apply px-1 text-salmon-50;
}
</style>
