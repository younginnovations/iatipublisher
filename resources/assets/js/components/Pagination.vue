<template>
  <nav class="pagination" aria-label="Pagination">
    <a href="#" class="prev-btn" @click="previousPage">
      <svg-vue icon="arrow-left"></svg-vue>
      <span class="">Prev</span>
    </a>

    <a
      v-for="index in parseInt(props.page_count)"
      :key="index"
      href="#"
      aria-current="page"
      @click="updateActivePage(index)"
      :class="active_page === index ? 'current' : ''"
    >
      {{ index }}
    </a>
    <a href="#" class="next-btn" @click="nextPage">
      <span class="">Next</span>
      <svg-vue icon="arrow-right"></svg-vue>
    </a>
  </nav>
</template>

<script lang="ts">
import { defineComponent, ref, watch } from 'vue';

export default defineComponent({
  name: 'pagination-component',
  components: {},
  props: {
    page_count: {
      type: [String],
      required: true,
    },
  },
  emits: ['fetchActivities'],
  setup(props, { emit }) {
    const active_page = ref(1);

    watch(active_page, () => {
      console.log(active_page.value);
      emit('fetchActivities', active_page.value);
    });

    function updateActivePage(page: number) {
      active_page.value = page;
    }

    function nextPage() {
      active_page.value =
        active_page.value === parseInt(props.page_count)
          ? 1
          : active_page.value + 1;
    }

    function previousPage() {
      active_page.value =
        active_page.value === 1
          ? parseInt(props.page_count)
          : active_page.value - 1;
    }

    return { props, active_page, updateActivePage, nextPage, previousPage };
  },
});
</script>
