<template>
  <CircleProgress
    :size="70"
    :percent="percent"
    :viewport="true"
    :show-percent="true"
    fill-color="#17997B"
    empty-color="#17997b26"
    :border-width="7"
    :border-bg-width="7"
  />
</template>

<script>
import CircleProgress from 'vue3-circle-progress';
import 'vue3-circle-progress/dist/circle-progress.css';
export default {
  name: 'App',
  components: {
    CircleProgress: CircleProgress,
  },
  props: {
    percent: { type: Number, default: 0 },
  },
};
</script>

<style lang="scss">
.vue3-circular-progressbar {
  svg {
    @apply h-auto;
  }
  .current-counter[data-v-49af6a0a] {
    @apply absolute top-2/4 left-2/4 -translate-y-2/4 -translate-x-2/4 font-bold text-spring-50;

    &:after {
      content: '%';
    }
  }
}
</style>
