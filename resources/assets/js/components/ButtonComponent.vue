<template>
  <button
    :disabled="activityLength || isLoading || disabled"
    class="button group relative text-n-40 transition-all duration-300 ease-in-out disabled:cursor-not-allowed disabled:bg-n-30 disabled:text-white"
    :class="[
      { '!cursor-not-allowed opacity-80': activityLength || isLoading },
      btnType,
    ]"
  >
    <svg-vue v-if="icon" :icon="icon" />
    <SpinnerLoader v-if="isLoading" />

    <span v-if="text">{{ text }} </span>

    <span
      v-if="tooltipText"
      class="invisible absolute top-12 left-1/2 z-10 w-[200px] -translate-x-1/2 cursor-default rounded-md bg-eggshell px-2 py-1 text-xs font-normal normal-case text-bluecoral opacity-0 group-hover:visible group-hover:opacity-100"
      >{{ tooltipText }}</span
    >
  </button>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import SpinnerLoader from './spinnerLoader.vue';

export default defineComponent({
  name: 'ButtonComponent',
  components: { SpinnerLoader },
  props: {
    text: {
      type: String,
      required: true,
    },
    isLoading: {
      type: Boolean,
      required: false,
      default: false,
    },

    icon: {
      type: String,
      required: false,
      default: '',
    },
    type: {
      type: String,
      required: false,
      default: '',
    },
    link: {
      type: String,
      required: false,
      default: '',
    },
    activityLength: {
      type: Boolean,
      required: false,
      default: false,
    },

    disabled: {
      type: Boolean,
      required: false,
      default: false,
    },
    tooltipText: {
      type: String,
      required: false,
      default: '',
    },
  },
  setup(props) {
    let btnType = '';
    if (props.type === 'secondary') {
      btnType = 'secondary-btn font-bold';
    } else if (props.type === 'outline') {
      btnType = 'primary-outline-btn';
    } else if (props.type === 'primary') {
      btnType = 'primary-btn font-bold';
    } else {
      btnType = 'font-bold';
    }

    return { btnType };
  },
});
</script>
