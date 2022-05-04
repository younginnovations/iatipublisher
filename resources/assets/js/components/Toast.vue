<template>
  <div :class="className">
    <svg-vue :icon="props.type ? 'check-circle' : 'times-circle'"></svg-vue>
    <span>{{ props.message }}</span>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue';

export default defineComponent({
  name: 'toast-cmp',
  components: {},
  props: {
    message: {
      type: String,
      required: true,
    },
    type: {
      type: Boolean,
      required: true,
    },
  },
  setup(props) {
    const className = ref('');
    className.value = props.type
      ? 'rounded-lg bg-mint border border-spring-10 py-4 px-5 inline-flex items-center space-x-1 text-xs leading-normal text-n-50'
      : 'rounded-lg bg-crimson-10 border border-crimson-20 py-4 px-5 inline-flex items-center space-x-1 text-xs leading-normal text-n-50';
    return {
      props,
      className,
    };
  },
});
</script>
