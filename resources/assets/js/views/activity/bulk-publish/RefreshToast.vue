<template>
  <div
    class="inline-flex items-center px-5 py-3 text-xs leading-normal border rounded-lg toast-notification text-n-50"
    :class="className"
  >
    <svg-vue
      class="mr-5"
      :icon="props.type ? 'check-circle' : 'times-circle'"
    />
    <span class="mr-5">{{ props.message }}</span>
    <a href="" class="inline-flex items-center uppercase text-spring-50">
      <svg-vue icon="redo" class="mr-1" />
      <span>Refresh</span>
    </a>
  </div>
</template>

<script setup lang="ts">
import { defineProps, ref } from 'vue';

const props = defineProps({
  message: { type: String, required: true },
  type: { type: Boolean, required: true },
});

const className = ref('');
className.value = props.type
  ? 'bg-mint border-spring-10'
  : 'bg-crimson-10 border-crimson-20';
</script>

<style scoped lang="scss">
.toast-notification {
  @apply absolute top-0 right-0 -translate-y-11;
}
</style>
