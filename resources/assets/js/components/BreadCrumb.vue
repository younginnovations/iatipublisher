<template>
  <div>
    <nav aria-label="breadcrumbs" class="breadcrumb">
      <p>
        <a href="/" class="font-bold text-n-40">Your Activities</a>
        <span class="separator"> / </span>
        <span class="last">Partnership against child exploitation</span>
      </p>
    </nav>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  setup: () => ({
    title: 'Breadcrumb Component',
  }),
});
</script>
