<template>
  <div class="overlay">
    <div class="overlay__inner">
      <div class="overlay__content">
        <span class="spinner" />
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'LoaderCmp',
});
</script>

<style lang="scss">
.overlay {
  @apply fixed left-0 top-0 h-full w-full bg-black;
  opacity: 0.7;
  z-index: 100;

  &__inner {
    @apply absolute left-0 top-0 h-full w-full;
  }

  &__content {
    @apply absolute left-2/4 top-2/4;
    transform: translate(-50%, -50%);

    .spinner {
      @apply inline-block animate-spin rounded-full border-2 border-n-10 border-opacity-5;
      width: 75px;
      height: 75px;
      border-top-color: white;
    }
  }
}
</style>
