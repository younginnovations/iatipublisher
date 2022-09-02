<template>
  <nav class="pagination" aria-label="Pagination">
    <a
      href="#"
      class="prev-btn"
      :class="{
        'pointer-events-none': data.last_page <= 1,
      }"
      aria-disabled="true"
      @click="previousPage"
    >
      <svg-vue icon="arrow-left"></svg-vue>
      <span class="">Prev</span>
    </a>

    <a
      v-for="(index, i) in data.last_page"
      :key="index"
      href="#"
      :class="active_page === index ? 'current' : ''"
      @click="changePage(i + 1)"
    >
      {{ index }}
    </a>
    <a
      href="#"
      class="next-btn"
      :class="{
        'pointer-events-none': data.last_page <= 1,
      }"
      @click="nextPage"
    >
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
    data: {
      type: [Object],
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

    function changePage(pageNum: number) {
      active_page.value =
        active_page.value === props.data.last_page ? 1 : pageNum;
    }

    function nextPage() {
      active_page.value =
        active_page.value === props.data.last_page ? 1 : active_page.value + 1;
    }

    function previousPage() {
      active_page.value =
        active_page.value === 1 ? props.data.last_page : active_page.value - 1;
    }

    return {
      props,
      active_page,
      updateActivePage,
      nextPage,
      previousPage,
      changePage,
    };
  },
});
</script>
