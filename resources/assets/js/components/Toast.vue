<template>
  <div :class="className">
    <span>{{ props.message }}</span>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue';

export default defineComponent({
  name: 'toast-cmp',
  components: {},
  props: {
    message: String,
    type: Boolean,
  },
  setup(props) {
    const className = ref('');
    className.value = props.type
      ? 'fixed right-10 top-20 inline-flex rounded-lg bg-eggshell py-4 px-8 text-sm leading-normal text-n-50'
      : 'fixed right-10 top-20 inline-flex rounded-lg bg-salmon-50 py-4 px-8 text-sm leading-normal text-n-50';
    return {
      props,
      className,
    };
  },
});
</script>
