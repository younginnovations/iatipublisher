<template>
  <nav class="pagination" aria-label="Pagination">
    <a href="#" class="prev-btn" @click="previousPage">
      <svg-vue icon="arrow-left" />
      <span class="">Prev</span>
    </a>

    <a
      v-for="index in parseInt(props.pageCount)"
      :key="index"
      href="#"
      aria-current="page"
      :class="active_page === index ? 'current' : ''"
      @click="updateActivePage(index)"
    >
      {{ index }}
    </a>
    <a href="#" class="next-btn" @click="nextPage">
      <span class="">Next</span>
      <svg-vue icon="arrow-right" />
    </a>
  </nav>
</template>

<script lang="ts">
import { defineComponent, ref, watch } from 'vue';

export default defineComponent({
  name: 'PaginationComponent',
  components: {},
  props: {
    pageCount: {
      type: [String],
      required: true,
    },
  },
  emits: ['fetchActivities'],
  setup(props, { emit }) {
    const active_page = ref(1);

    watch(active_page, () => {
      emit('fetchActivities', active_page.value);
    });

    function updateActivePage(page: number) {
      active_page.value = page;
    }

    function nextPage() {
      active_page.value =
        active_page.value === parseInt(props.pageCount)
          ? 1
          : active_page.value + 1;
    }

    function previousPage() {
      active_page.value =
        active_page.value === 1
          ? parseInt(props.pageCount)
          : active_page.value - 1;
    }

    return { props, active_page, updateActivePage, nextPage, previousPage };
  },
});
</script>
