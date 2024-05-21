<template>
  <divz class="my-2 flex space-x-2 rounded-lg bg-eggshell py-2 px-4">
    <svg-vue icon="exclamation-warning" class="h-6 -translate-y-1.5"></svg-vue>

    <!-- eslint-disable vue/no-v-html -->
    <div class="text-xs font-normal text-n-50" v-html="helperText"></div>
  </divz>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';

defineProps({
  helperText: {
    type: String,
    required: true,
  },
});
</script>

<style lang="scss"></style>
