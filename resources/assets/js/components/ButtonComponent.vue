<template>
  <button
    :disabled="activityLength"
    class="button relative text-n-40"
    :class="activityLength ? `${btnType} !cursor-not-allowed` : btnType"
  >
    <svg-vue v-if="icon" :icon="icon" />
    <span v-if="text">{{ text }} </span>
  </button>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'ButtonComponent',
  components: {},
  props: {
    text: {
      type: String,
      required: true,
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
