<template>
  <div
    class="flex items-center rounded bg-mint p-1.5 text-xs font-normal leading-normal text-n-50"
  >
    <svg-vue v-if="icon" :icon="icon" class="mr-1.5 text-base text-spring-50" />
    <span>{{ text }}</span>
  </div>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';

defineProps({
  text: {
    type: String,
    default: window['globalLang'].common.previously_published_on_iati,
  },
  icon: { type: String, default: 'approved-cloud' },
});
</script>
