<template>
  <div>
    <nav aria-label="breadcrumbs" class="breadcrumb">
      <p>
        <a href="#" class="font-bold text-n-40">{{ link }}</a>
        <span class="separator"> / </span>
        <span class="last">{{ title }}</span>
        <span class="separator"> / </span>
        <span class="last">Partnership against child exploitation</span>
      </p>
    </nav>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  props: {
    title: {
      type: String,
      required: true,
    },
    link: {
      type: String,
      required: true,
    },
  },
  setup: (props) => ({
    return: {
      props,
    },
  }),
});
</script>
