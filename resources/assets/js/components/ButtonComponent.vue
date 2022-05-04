<template>
  <button class="button relative font-bold text-n-40" :class="btnType">
    <svg-vue :icon="icon" v-if="icon"></svg-vue>
    <span>{{ text }}</span>
  </button>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'button-component',
  components: {},
  props: {
    text: String,
    icon: String,
    type: String,
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
