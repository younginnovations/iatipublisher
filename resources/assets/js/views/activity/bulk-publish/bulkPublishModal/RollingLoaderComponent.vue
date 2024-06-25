<template>
  <div class="pt-2.5">
    <p
      class="!mb-0 flex items-center gap-1 pb-2.5 text-sm font-bold leading-[22px] tracking-normal text-bluecoral"
    >
      <svg-vue class="text-xl" icon="progress-icon" />
      <span>
        {{ header }}
      </span>
    </p>
    <div class="progressBar_container">
      <div class="progress_bar" />
    </div>
  </div>
</template>

<script setup>
import { defineProps } from 'vue';
defineProps({
  header: {
    type: String,
    default: 'Loading..',
  },
});
</script>
<style scoped lang="scss">
.progressBar_container {
  @apply relative h-[7px] overflow-hidden rounded-lg bg-[#C4C4C4];
}

.progress_bar {
  @apply absolute h-full w-28 rounded-lg bg-spring-50;
  animation: moveRightLeft 2s linear infinite;
}

@keyframes moveRightLeft {
  0% {
    left: -40px;
  }
  100% {
    left: 100%;
  }
}
</style>
