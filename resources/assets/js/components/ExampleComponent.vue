<template>
  <div>
    test
    <p>{{ title }}</p>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  setup: () => ({
    title: 'Vue3 with composition API',
  }),
});
</script>
