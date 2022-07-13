<template>
  <button class="button relative font-bold text-n-40" :class="btnType">
    <svg-vue v-if="icon" :icon="icon" />
    <span>{{ text }}</span>
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
      default: "",
    },
  },
  setup(props) {
    let btnType = '';
    if (props.type === 'secondary') {
      btnType = 'secondary-btn';
    } else if (props.type === 'outline') {
      btnType = 'primary-outline-btn';
    } else if (props.type === 'primary') {
      btnType = 'primary-btn';
    }
    return { btnType };
  },
});
</script>
