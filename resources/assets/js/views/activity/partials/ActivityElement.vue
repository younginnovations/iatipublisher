<template>
  <div :class="layout" class="activities__content--element px-3 py-3">
    <div class="rounded-lg bg-white p-4">
      <div class="mb-4 flex">
        <div class="title flex grow">
          <svg-vue :icon="icon" class="mr-1.5 text-xl text-bluecoral"></svg-vue>
          <div class="title text-sm font-bold">{{ title }}</div>
          <div
            v-if="status"
            class="status ml-2.5 flex text-xs leading-5 text-spring-50"
          >
            <b class="mr-2 text-base leading-3">.</b>
            <span>{{ status }}</span>
          </div>
        </div>
        <div class="icons flex">
          <a
            v-if="hovered"
            class="mr-2.5 flex items-center text-xs font-bold uppercase"
            href="/title-form"
          >
            <svg-vue class="mr-0.5 text-base" icon="edit"></svg-vue>
            <span>Edit</span>
          </a>
          <svg-vue class="mr-1.5" icon="core"></svg-vue>
          <HoverText v-if="tooltip" :hover_text="tooltip" name=""></HoverText>
        </div>
      </div>
      <div class="divider mb-4 h-px w-full bg-n-20"></div>
      <div class="content">
        <div v-if="language" class="language mb-1.5 text-sm italic text-n-30">
          (Language: {{ language }})
        </div>
        <div class="text-sm">{{ content }}</div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue';
import { useElementHover } from '@vueuse/core';
import HoverText from '../../../components/HoverText.vue';

export default defineComponent({
  name: 'activity-element',
  components: { HoverText },
  props: {
    title: {
      type: String,
      required: true,
    },
    icon: {
      type: String,
      required: true,
    },
    status: {
      type: String,
      required: false,
    },
    tooltip: {
      type: String,
      required: false,
    },
    content: {
      type: String,
      required: true,
    },
    width: {
      type: String,
      required: false,
    },
    language: {
      type: String,
      required: false,
    },
    hovered: {
      type: Boolean,
      required: false,
      default: false,
    },
  },
  setup(props) {
    let layout = 'basis-6/12';
    if (props.width === 'full') {
      layout = 'basis-full';
    }

    const myHoverableElement = ref();
    const isHovered = useElementHover(myHoverableElement);

    return { layout, isHovered };
  },
});
</script>
