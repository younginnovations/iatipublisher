<template>
  <div class="mt-6 w-full bg-white py-6 px-14">
    <div></div>

    <div></div>
  </div>
</template>
<script lang="ts" setup>
import { ref, defineProps } from 'vue';
const props = defineProps({
  currentView: {
    type: String,
    required: true,
  },
});
</script>
