<template>
  <div class="help">
    <button>
      <svg-vue
        class="text-n-40"
        :class="{
          'text-tiny': iconSize,
          iconSize: !iconSize,
        }"
        icon="help"
      />
    </button>
    <div
      :class="[
        position === 'right'
          ? 'help__text left-0 ' + width
          : 'help__text right-0 ' + width,
      ]"
    >
      <span class="font-bold text-bluecoral">{{ name }}</span>
      <p v-html="hoverText" />
      <a v-if="link" :href="link" class="inline-block font-bold text-bluecoral"
        >Learn more</a
      >
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue';

export default defineComponent({
  props: {
    name: {
      type: String,
      required: false,
      default: '',
    },
    hoverText: {
      type: String,
      required: true,
    },
    width: {
      type: String,
      required: false,
      default: 'w-60',
    },
    position: {
      type: String,
      required: false,
      default: '',
    },
    link: {
      type: String,
      required: false,
      default: '',
    },
    iconSize: {
      type: String,
      required: false,
      default: '',
    },
  },
});
</script>

<style lang="scss">
.help {
  @apply relative;

  &__text {
    @apply invisible absolute top-4 z-20 space-y-1.5 rounded bg-eggshell p-4 text-left text-xs text-n-40 opacity-0 duration-200;
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
