<template>
  <a v-if="link" :href="link" :class="classes">
    <svg-vue v-if="icon" class="mr-0.5 text-base" :icon="icon"></svg-vue>
    <span class="whitespace-nowrap">{{ text }}</span>
  </a>
  <span v-else :class="classes" class="text-bluecoral">
    <svg-vue v-if="icon" class="mr-0.5 text-base" :icon="icon"></svg-vue>
    <span class="whitespace-nowrap">{{ text }}</span>
  </span>
</template>

<script lang="ts">
import { defineComponent, toRefs } from 'vue';

export default defineComponent({
  name: 'LinkButton',
  components: {},
  props: {
    text: {
      type: String,
      required: true,
    },
    link: {
      type: String,
      required: false,
      default: '',
    },
    icon: {
      type: String,
      required: false,
      default: 'edit',
    },
    design: {
      type: String,
      required: false,
      default: 'iconText',
    },
  },
  setup(props) {
    const { design } = toRefs(props);

    const styleType = design.value;
    let classes = '';

    switch (styleType) {
      case 'bgText':
        classes = 'flex items-center bg-n-10 p-1 text-tiny font-bold uppercase';
        break;
      default:
        classes =
          'flex items-center font-bold leading-normal uppercase text-tiny';
    }

    return { classes };
  },
});
</script>
