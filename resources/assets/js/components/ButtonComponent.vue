<template>
  <button
    :disabled="activityLength || isLoading"
    class="button relative text-n-40"
    :class="[
      { '!cursor-not-allowed opacity-80': activityLength || isLoading },
      btnType,
    ]"
  >
    <svg-vue v-if="icon" :icon="icon" />
    <SpinnerLoader v-if="isLoading" />

    <span v-if="text">{{ text }} </span>
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
