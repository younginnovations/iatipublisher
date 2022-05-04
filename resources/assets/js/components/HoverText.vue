<template>
  <div class="help">
    <button class="">
      <svg-vue class="cursor-pointer text-base" icon="help"></svg-vue>
    </button>
    <div
      class="help__text"
      :class="props.position === 'left' ? 'left-0' : 'right-0'"
    >
      <p class="font-bold text-bluecoral">{{ props.name }}</p>
      <p>{{ props.hover_text }}</p>
      <a
        :href="props.link"
        v-if="props.link"
        class="inline-block font-bold text-bluecoral"
        >Learn more</a
      >
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  props: {
    name: String,
    hover_text: String,
    position: String,
    link: String,
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
    @apply invisible absolute top-4 z-20 w-60 space-y-1.5 rounded bg-eggshell p-2 text-xs text-n-50 opacity-0 duration-200;
    transition: all 0.3s ease-out;
    box-shadow: 0px 4px 40px rgb(0 0 0 / 10%);
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
