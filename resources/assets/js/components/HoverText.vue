<template>
  <div class="help">
    <button class="">
      <svg-vue class="cursor-pointer text-base" icon="help"></svg-vue>
    </button>
    <div class="help__text" :class="hoverTextClass">
      <span class="font-bold">{{ props.name }}</span>
      <p v-html="props.hover_text"></p>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue';

export default defineComponent({
  props: {
    name: String,
    hover_text: String,
    width: String,
  },
  setup(props) {
    const hoverTextClass = ref('');
    hoverTextClass.value = props.width ? props.width : 'w-60';

    return {
      props,
      hoverTextClass,
    };
  },
});
</script>

<style lang="scss">
.help {
  @apply relative;

  &__text {
    @apply invisible absolute right-0 top-4 z-20 rounded bg-eggshell p-2 text-left text-xs text-n-40 opacity-0 duration-200;
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
