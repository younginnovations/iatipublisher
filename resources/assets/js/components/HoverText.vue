<template>
  <div class="help">
    <button>
      <svg-vue
        :class="{
          'text-tiny': props.iconSize,
          iconSize: !props.iconSize,
        }"
        icon="help"
      ></svg-vue>
    </button>
    <div
      :class="
        props.position === 'right'
          ? 'help__text left-0 ' + hoverTextClass
          : 'help__text right-0 ' + hoverTextClass
      "
    >
      <span class="font-bold text-bluecoral">{{ props.name }}</span>
      <p v-html="props.hoverText"></p>
      <a
        v-if="props.link"
        :href="props.link"
        class="inline-block font-bold text-bluecoral"
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
    },
    hoverText: {
      type: String,
      required: true,
    },
    width: {
      type: String,
      required: false,
    },
    position: {
      type: String,
      required: false,
    },
    link: {
      type: String,
      required: false,
    },
    iconSize: {
      type: String,
      required: false,
    },
  },
  setup(props) {
    const hoverTextClass = ref('');
    const iconSize = ref('');
    hoverTextClass.value = props.width ? props.width : 'w-60';
    iconSize.value = props.iconSize ? props.iconSize : 'text-sm';

    return {
      props,
      iconSize,
      hoverTextClass,
    };
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
