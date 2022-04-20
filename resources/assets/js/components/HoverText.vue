<template>
  <div class="help">
    <button class="">
      <svg-vue class="cursor-pointer text-base" icon="help"></svg-vue>
    </button>
    <div class="help__text">
      <span class="font-bold">{{ props.name }}</span>
      <p>{{ props.hover_text }}</p>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  props: {
    name: String,
    hover_text: String,
  },
  setup(props) {
    return {
      props,
    };
  },
});
</script>

<style lang="scss">
.help {
  @apply relative pb-2;

  &__text {
    @apply invisible absolute right-0 top-4 z-20 w-60 rounded bg-eggshell p-2 text-xs leading-5 text-n-40 opacity-0 duration-200;
    transition: all 0.3s ease-out;
  }
}

.help:hover {
  .help__text {
    transform: translateY(5px);
    visibility: visible;
    opacity: 1;
  }
}
</style>
