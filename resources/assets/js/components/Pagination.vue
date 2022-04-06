<template>
  <nav class="pagination" aria-label="Pagination">
    <a href="#" class="prev-btn">
      <svg-vue icon="arrow-left"></svg-vue>
      <span class="">Prev</span>
    </a>
    <a href="#" aria-current="page" class="current"> 1 </a>
    <a href="#" class=""> 2 </a>
    <a href="#" class=""> 3 </a>
    <span class=""> ... </span>
    <a href="#" class=""> 8 </a>
    <a href="#" class=""> 9 </a>
    <a href="#" class=""> 10 </a>
    <a href="#" class="next-btn">
      <span class="">Next</span>
      <svg-vue icon="arrow-right"></svg-vue>
    </a>
  </nav>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'pagination-component',
  components: {},
});
</script>
